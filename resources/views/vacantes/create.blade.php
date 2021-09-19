@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('navegacion')
     @include('ui.adminav')
@endsection

@section('content')
    <h1 class="text-2xl text-center mt-10">Nueva Vacante</h1>

    <form class="max-w-lg mx-auto my-10" action="">
        <div class="mb-5">
            <label for="titulo" class="block text-gray-700 text-sm mb-2">Titulo Vacante:</label>
            <input id="titulo" type="text" class="p-3 bg-gray-100 rounded form-input w-full  @error('titulo') is-invalid @enderror" name="titulo"  autocomplete="current-password">


        </div>
        
        <div class="mb-5">
            <label for="categoria" class="block text-gray-700 text-sm mb-2">Categoría:</label>
            <select name="categoria" id="categoria" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full">
                <option disabled selected value="">- Selecciona -</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id}}">
                    {{$categoria->nombre}}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-5">
            <label for="experiencia" class="block text-gray-700 text-sm mb-2">Experiencia:</label>
            <select name="experiencia" id="experiencia" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full">
                <option disabled selected value="">- Selecciona -</option>
                @foreach ($experiencias as $experiencia)
                    <option value="{{$experiencia->id}}">
                    {{$experiencia->nombre}}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-5">
            <label for="ubicacion" class="block text-gray-700 text-sm mb-2">Ubicacion:</label>
            <select name="ubicacion" id="ubicacion" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full">
                <option disabled selected value="">- Selecciona -</option>
                @foreach ($ubicaciones as $ubicacion)
                    <option value="{{$ubicacion->id}}">
                    {{$ubicacion->nombre}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label for="salario" class="block text-gray-700 text-sm mb-2">Salario:</label>
            <select name="salario" id="salario" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full">
                <option disabled selected value="">- Selecciona -</option>
                @foreach ($salarios as $salario)
                    <option value="{{$salario->id}}">
                    {{$salario->nombre}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label for="descripcion" class="block text-gray-700 text-sm mb-2">Descripción de la Vacante:</label>
            <div class="editable p-3 bg-gray-100 rounded form-input w-full text-gray-700"></div>
            <input type="hidden" name="descripcion" id="descripcion">
        </div>


        <div class="mb-5">
            <label for="descripcion" class="block text-gray-700 text-sm mb-2">Imagen de la Vacante:</label>
            <div class="dropzone rounded bg-gray-100" id="dropzoneDevJobs"></div>
            <input type="hidden" name="imagen" id="imagen">
            <p id="error"></p>
            
        </div>


        <button class="bg-green-500 w-full hover:bg-green-600 text-gray-100 font-bold p-3 focus:outline focus:shadow-outline uppercase" type="submit">Publicar Vacantes</button>
    
    </form>

    @section('scripts')
    <script src="//cdn.jsdelivr.net/npm/medium-editor@latest/dist/js/medium-editor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <script>

        Dropzone.autoDiscover = false;

        document.addEventListener('DOMContentLoaded', () => {

            // Medium Editor
            const editor = new MediumEditor('.editable', {
                toolbar : {
                    buttons: ['bold', 'italic', 'underline', 'quote', 'anchor', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull',  'orderedlist', 'unorderedlist', 'h2', 'h3'],
                    static: true,
                    sticky: true
                },
                placeholder: {
                    text: 'Información de la vacante'
                }
            });

            // Agrega al input hidden lo que el usuario escribe en medium editor
            editor.subscribe('editableInput', function(eventObj, editable) {
                const contenido = editor.getContent();
                document.querySelector('#descripcion').value = contenido;
            })

            // Llena el editor con el contenido del input hidden
            editor.setContent( document.querySelector('#descripcion').value );

            // Dropzone
            const dropzoneDevJobs = new Dropzone('#dropzoneDevJobs', {
                url: "/vacantes/imagen",
                dictDefaultMessage: 'Sube aquí tu archivo',
                acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
                addRemoveLinks: true,
                dictRemoveFile: 'Borrar Archivo',
                maxFiles: 1,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                init: function() {
                    if(document.querySelector('#imagen').value.trim() ) {
                       let imagenPublicada = {};
                       imagenPublicada.size = 1234;
                       imagenPublicada.name = document.querySelector('#imagen').value;
                       
                       this.options.addedfile.call(this, imagenPublicada);
                       this.options.thumbnail.call(this, imagenPublicada, `/storage/vacantes/${imagenPublicada.name}`);

                       imagenPublicada.previewElement.classList.add('dz-sucess');
                       imagenPublicada.previewElement.classList.add('dz-complete');
                    } 
                },
                success: function(file, response) {
                    // console.log(file);
                    // console.log(response);
                    console.log(response.correcto);
                    document.querySelector('#error').textContent = '';

                    // Coloca la respuesta del servidor en el input hidden
                    document.querySelector('#imagen').value = response.correcto;

                    // Añadir al objeto de archivo el nombre del servidor
                    file.nombreServidor = response.correcto;
                },
                maxfilesexceeded: function(file) {
                    if( this.files[1] != null ) {
                        this.removeFile(this.files[0]); // eliminar el archivo anterior
                        this.addFile(file); // Agregar el nuevo archivo 
                    }
                }, 
                removedfile: function(file, response) {
                    file.previewElement.parentNode.removeChild(file.previewElement);

                    params = {
                        imagen: file.nombreServidor ?? document.querySelector('#imagen').value
                    }

                    axios.post('/vacantes/borrarimagen', params )
                        .then(respuesta => console.log(respuesta))
                }
            });

        })
    </script>
    

    @endsection
@endsection