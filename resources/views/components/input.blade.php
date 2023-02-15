<div>
    <label for="{{$id}}" class="block text-sm font-medium text-gray-700">{{$label}}</label>
    <div class="mt-1">
        <input id="{{$id}}" name="{{$name}}" type="{{$type}}"
               class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
               placeholder="{{$placeHolder}}"
               wire:model.lazy="{{$model}}"
        >
        @error($model)<span class="mt-1 text-sm text-red-700">{{ $message }}</span>@enderror
    </div>
</div>
