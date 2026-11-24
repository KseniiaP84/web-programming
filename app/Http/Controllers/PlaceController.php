<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private array $places = [
        [
            'id' => 1,
            'name' => 'Міська бібліотека',
            'category' => 'Бібліотека',
            'address' => 'вул. Незалежності, 10',
            'city' => 'Івано-Франківськ',
            'accessibility_description' => 'Є пандус та доступний вхід',
            'status' => 'approved',
        ],
        [
            'id' => 2,
            'name' => 'Центр надання послуг',
            'category' => 'Установа',
            'address' => 'вул. Грушевського, 5',
            'city' => 'Івано-Франківськ',
            'accessibility_description' => 'Є ліфт',
            'status' => 'approved',
        ],
    ];

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->places,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'accessibility_description' => ['required', 'string', 'max:1000'],
        ]);

        $newPlace = array_merge($validated, [
            'id' => count($this->places) + 1,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'created',
            'message' => 'Заклад додано та передано на модерацію.',
            'data' => $newPlace,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        foreach ($this->places as $place) {
            if ($place['id'] === (int) $id) {
                return response()->json([
                    'status' => 'success',
                    'data' => $place,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Заклад не знайдено.',
        ], 404);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json([
            'message' => 'Метод оновлення буде реалізовано.',
            'id' => $id,
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        return response()->json([
            'message' => 'Метод видалення буде реалізовано.',
            'id' => $id,
        ], 200);
    }
}
