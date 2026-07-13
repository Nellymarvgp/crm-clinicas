@extends('layouts.master-layouts')
@section('title')
    {{ __('App Setting') }}
@endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title')
                Configuración de CORE
            @endslot
            @slot('li_1')
                Dashboard
            @endslot
            @slot('li_2')
                Configuración
            @endslot
            @slot('li_3')
                CORE
            @endslot
        @endcomponent
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Instrucciones de configuración') }}</blockquote>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/title.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Nombre de la app</h4>
                                        <p class="card-text">Se muestra en la cabecera y en los títulos del sistema.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/logo-sm.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo pequeño</h4>
                                        <p class="card-text">Se muestra en pantallas móviles y vistas compactas.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/logo-lg.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo grande</h4>
                                        <p class="card-text">Se muestra en las vistas principales del sistema.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/logo-sm-dark.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo oscuro pequeño</h4>
                                        <p class="card-text">Se usa cuando la barra superior es clara en móvil.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/logo-lg-dark.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Logo oscuro grande</h4>
                                        <p class="card-text">Se usa cuando la barra superior es clara.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card border border-primary">
                                    <img class="card-img-top img-fluid" src="{{ URL::asset('build/images/settings/favicon.png') }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title mb-2">Favicon</h4>
                                        <p class="card-text">Se muestra junto al título de la página.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Setting Details') }}</blockquote>
                        <form action="{{ route('update-setting') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appTitle">Nombre de la app <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="appTitle" value="{{ @$data->title }}" name="title">
                                        <small id="appTitleHelp" class="form-text text-muted">Ingrese entre 5 y 40 caracteres.</small>
                                        @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo pequeño</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_sm">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 64x75.</small>
                                        @error('logo_sm')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo grande</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_lg">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 440x75.</small>
                                        @error('logo_lg')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo oscuro pequeño</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_sm">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 64x75.</small>
                                        @error('logo_dark_sm')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo oscuro grande</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_lg">
                                        <small class="form-text text-muted">Solo jpg, png o svg. Tamaño recomendado: 440x75.</small>
                                        @error('logo_dark_lg')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appFavicon">Favicon</label>
                                        <input type="file" class="form-control" id="appFavicon" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" name="favicon">
                                        <small class="form-text text-muted">Solo jpg, png, svg o ico. Tamaño recomendado: 128x128.</small>
                                        @error('favicon')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <blockquote>{{ __('Datos del pie de página') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerLeft">Pie izquierdo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerLeft" name="footer_left" value="{{ @$data->footer_left }}">
                                        <small class="form-text text-muted">Ingrese entre 5 y 40 caracteres.</small>
                                        @error('footer_left')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerRight">Pie derecho <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerRight" name="footer_right" value="{{ @$data->footer_right }}">
                                        <small class="form-text text-muted">Ingrese entre 5 y 80 caracteres.</small>
                                        @error('footer_right')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
