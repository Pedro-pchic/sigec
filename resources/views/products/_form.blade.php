<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="category_id" class="block text-sm font-medium">Categoría</label>
        <select id="category_id" name="category_id" required
            class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            <option value="">Selecciona una categoría</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>
                    {{ $category->name }}{{ $category->is_active ? '' : ' — Inactiva' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="sku" class="block text-sm font-medium">SKU</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku ?? '') }}" required
            class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
    </div>

    <div>
        <label for="name" class="block text-sm font-medium">Nombre</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required
            class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
    </div>

    <div>
        <label for="price" class="block text-sm font-medium">Precio</label>
        <input id="price" name="price" type="number" min="0" max="9999999999.99" step="0.01" value="{{ old('price', $product->price ?? '') }}" required
            class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium">Descripción</label>
        <textarea id="description" name="description" rows="4"
            class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <label class="flex items-center gap-2 text-sm font-medium">
            <input name="is_active" type="checkbox" value="1" @checked((bool) old('is_active', $product->is_active ?? true))
                class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Producto activo
        </label>
    </div>
</div>
