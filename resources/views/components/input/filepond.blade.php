<div
    wire:ignore
    x-data
    x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const pond = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }}, {
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
            credits: null,
        });

        this.addEventListener('pond-reset', event => {
            pond.removeFile()
        });
    "
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" id="{{ $attributes->get('wire:model') ?? 'input' }}">
</div>
