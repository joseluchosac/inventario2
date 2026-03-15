@php
    $breadcrumbs = [
        [
            'name' => 'Productos',
            'href' => route('admin.products.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ];
@endphp

<x-admin-layout title="Editar producto" :breadcrumbs="$breadcrumbs">
    <div class="max-w-4xl mx-auto">
        @push('css')
            <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        @endpush
        <div>
            <form action="{{ route('admin.products.dropzone', $product)}}" class="dropzone" id="my-dropzone" method="POST">
                @csrf
            </form>
        </div>
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.products.update', $product) }}" method="POST">
                @method('PUT')
                @csrf
                <x-wire-input label="Nombre" name="name" value="{{ old('name', $product->name) }}" />
                
                <x-wire-textarea label="Descripción" name="description">
                    {{ old('description', $product->description) }}
                </x-wire-textarea>

                <x-wire-input label="Precio" name="price" value="{{ old('price', $product->price) }}" type="number" step="0.01" />

                <x-wire-native-select label="Categoría" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected(old('category_id', $product->category_id) == $category->id) >
                            {{$category->name}}
                        </option>
                    @endforeach
                </x-wire-native-select>
                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('admin.products.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Actualizar</x-button>
                </div>

            </form>
        </x-wire-card>
        @push('js')
            <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
            <script>
                Dropzone.options.myDropzone = {
                    addRemoveLinks: true,
                    init: function() {
                        let myDropzone = this;
                        let images = @json($product->images);
                        images.forEach(image => {
                            let mockFIle = {
                                id: image.id,
                                name: image.path.split('/').pop(),
                                size: image.size,
                            }
                            myDropzone.displayExistingFile(mockFIle, `{{ Storage::url('${image.path}') }}`);
                            myDropzone.emit('complete', mockFIle);
                            myDropzone.files.push(mockFIle);
                        });

                        this.on('success', function(file, response){
                            file.id = response.id;
                        })
                            

                        this.on('removedfile', function(file){
                            axios.delete(`/admin/images/${file.id}`)
                            .then(function (response) {
                                // console.log(response);
                            }).catch(function (error) {
                                console.log(error);
                            });
                        })
                    }
                };
            </script>
        @endpush
    </div>
</x-admin-layout>
