<div class="{{$viewClass['form-group']}} {!! !$errors->hasAny($errorKey) ? '' : 'has-error' !!}">

    <label for="{{ $id }}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}} ">

        @foreach($errorKey as $key => $col)
            @if($errors->has($col))
                @foreach($errors->get($col) as $message)
                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$message}}</label><br/>
                @endforeach
            @endif
        @endforeach

        <div id="{{ $id }}" {!! $attributes !!} class="row">
            <div class="col-md-4">
                <select
                        @if($enable_select2)
                            data-toggle="select2"
                        @endif
                        class="form-control"
                        name="{{$name['province']}}"
                        data-province="{{ $value['province']??'' }}"
                ></select>&nbsp;
            </div>
            <div class="col-md-4">
                <select
                        @if($enable_select2)
                            data-toggle="select2"
                        @endif
                        class="form-control"
                        name="{{$name['city']}}"
                        data-city="{{ $value['city']??'' }}"
                ></select>&nbsp;
            </div>
            <div class="col-md-4">
                <select
                        @if($enable_select2)
                            data-toggle="select2"
                        @endif
                        class="form-control"
                        name="{{$name['district']}}"
                        data-district="{{ $value['district']??'' }}"
                ></select>&nbsp;
            </div>



        </div>
        @include('admin::form.help-block')

    </div>
</div>
<script require="@sparkinzy.dcat-distpicker{{ $enable_select2?',@select2':''  }}" init="#{!! $id !!}">
    @if($enable_select2)
    $('.dcat-distpicker-select').select2();
    @endif
</script>
