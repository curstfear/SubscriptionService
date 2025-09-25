<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Logo;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Requests\StoreSectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index', ['sections' => Section::orderBy('order')->get()]);
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(StoreSectionRequest $request)
    {
        $lastOrder = Section::max('order') ?? 0;

        $section = Section::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->file('image') ? $request->file('image')->store('sections', 'public') : null,
            'link' => $request->link,
            'is_reversed' => $request->is_reversed,
            'order' => $lastOrder + 1,
            'type' => 'default',
            'is_visible' => true,
            'page_id' => 1,
        ]);

        return redirect()->route('admin.sections.index');
    }

    public function edit(Section $section)
    {
        $view = match ($section->type) {
            'top' => 'admin.sections.edit-top',
            'pricing' => 'admin.sections.edit-pricing',
            'logos' => 'admin.sections.edit-logos',
            default => 'admin.sections.edit-default',
        };

        return view($view, ['section' => $section]);
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }
            $data['image_url'] = $request->file('image')->store('sections', 'public');
        }

        $section->update($data);
        if ($section->type === 'logos') {
            $this->updateLogos($request, $section);
        }

        return redirect()->route('admin.sections.index')->with('success', 'Секция обновлена!');
    }

    public function destroy(Section $section)
    {
        \Log::info('Attempting to delete section: ' . $section->id);

        try {
            $deletedOrder = $section->order;

            // Удаляем файл изображения, если есть
            if ($section->image_url && Storage::disk('public')->exists($section->image_url)) {
                Storage::disk('public')->delete($section->image_url);
            }

            // Удаляем секцию
            $section->delete();

            // Пересчитываем order для всех секций, которые были после удаленной
            Section::where('order', '>', $deletedOrder)
                ->decrement('order');

            \Log::info('Section deleted successfully and orders rebalanced');

            return redirect()->route('admin.sections.index')
                ->with('success', 'Секция удалена!');

        } catch (\Exception $e) {
            \Log::error('Error deleting section: ' . $e->getMessage());

            return redirect()->route('admin.sections.index')
                ->with('error', 'Ошибка при удалении секции: ' . $e->getMessage());
        }
    }

    public function toggleVisibility(Request $request, Section $section)
    {
        $section->update(['is_visible' => $request->input('is_visible')]);

        return response()->json(['success' => true]);
    }

    private function updateLogos(Request $request, Section $section)
    {
        if ($request->has('links')) {
            foreach ($request->links as $logoId => $link) {
                $logo = Logo::where('id', $logoId)->where('section_id', $section->id)->first();
                if ($logo) {
                    $logo->link_url = $link;
                    if ($request->hasFile("images.$logoId")) {
                        if ($logo->image_url && Storage::disk('public')->exists($logo->image_url)) {
                            Storage::disk('public')->delete($logo->image_url);
                        }
                        $logo->image_url = $request->file("images.$logoId")->store('logos', 'public');
                    }
                    $logo->save();
                }
            }
        }

        if ($request->filled('delete_ids')) {
            $deleteIds = explode(',', $request->delete_ids);
            foreach ($deleteIds as $deleteId) {
                $logo = Logo::where('id', $deleteId)->where('section_id', $section->id)->first();
                if ($logo) {
                    if ($logo->image_url && Storage::disk('public')->exists($logo->image_url)) {
                        Storage::disk('public')->delete($logo->image_url);
                    }
                    $logo->delete();
                }
            }
        }

        $newLinks = $request->input('new_links', []);
        $newImages = $request->file('new_images', []);
        foreach ($newLinks as $index => $link) {
            if (!empty($link) || isset($newImages[$index])) {
                $imagePath = isset($newImages[$index]) && $newImages[$index]->isValid()
                    ? $newImages[$index]->store('logos', 'public')
                    : null;
                $section->logos()->create([
                    'link_url' => $link ?: null,
                    'image_url' => $imagePath,
                ]);
            }
        }
    }


    public function changeOrder(Request $request, Section $section)
    {
        $direction = $request->input('direction');
        if ($direction === 'up') {
            $neighbor = Section::where('order', '<', $section->order)
                ->orderBy('order', 'desc')
                ->first();
        } else {
            $neighbor = Section::where('order', '>', $section->order)
                ->orderBy('order', 'asc')
                ->first();
        }
        if ($neighbor) {
            $temp = $section->order;
            $section->order = $neighbor->order;
            $neighbor->order = $temp;
            $section->save();
            $neighbor->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Не удалось изменить порядок']);
    }
}