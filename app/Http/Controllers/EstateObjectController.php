<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\EstateObject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EstateObjectController extends Controller
{
    public function get_estateObjects() {
         $estateObjects = EstateObject::all();
         return Inertia::render('EstateObjects', [
            'title' => 'Объекты',
            'estateObjects' => $estateObjects,
        ]);
    }

    public function get_form()
    {
        return Inertia::render('CreateObject', [
            'title' => 'СоздатьОбъект'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
         // Заменяем все "null"-строки на null
        foreach ($data as $key => $value) {
            if ($value === 'null') {
                $data[$key] = null;
            }
        }
   
        if ($request->hasFile('image')) {
            $data['image'] = EstateObject::storeImage($request->file('image'));
        }
        // EstateObject::create($validated);
        EstateObject::create($data);

        return back()->with('success', 'Объект успешно создан.');
    }

    public function destroy($id)
    {
        $object = EstateObject::findOrFail($id);

        // Удаляем изображение, если оно было
        if ($object->image) {
            Storage::disk('public')->delete($object->image);
        }

        $object->delete();

        return redirect('/objects');
    }

    public function edit($id)
    {
        $estateObject = EstateObject::findOrFail($id);

        return Inertia::render('UpdateObject', [
            'title' => 'Редактирование объекта',
            'estateObject' => $estateObject,
        ]);
    }

public function update(Request $request, $id)
{   
    $data = $request->all();
    $estateObject = EstateObject::findOrFail($id);
      if ($request->hasFile('image')) {
            $data['image'] = EstateObject::storeImage($request->file('image'));
        }
    // Обновляем объект
    $estateObject->update($data);
    // Перенаправляем
    return redirect('/objects');
}
 
}
