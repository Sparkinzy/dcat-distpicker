<div class="{{$viewClass['form-group']}} {!! !$errors->hasAny($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}} ">

        @foreach($errorKey as $key => $col)
            @if($errors->has($col))
                @foreach($errors->get($col) as $message)
                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$message}}</label><br/>
                @endforeach
            @endif
        @endforeach

        <div id="{{ $id }}" {!! $attributes !!} class="row">
            <select
                    @if($enable_select2)
                    data-toggle="select2"
                    @endif
                    class="form-control col-md-3"
                    name="{{$name['province']}}"
                    data-province="{{ $value['province']??'' }}"
            ></select>&nbsp;
            <select
                    @if($enable_select2)
                    data-toggle="select2"
                    @endif
                    class="form-control col-md-3"
                    name="{{$name['city']}}"
                    data-city="{{ $value['city']??'' }}"
            ></select>&nbsp;
            <select
                    @if($enable_select2)
                    data-toggle="select2"
                    @endif
                    class="form-control col-md-3"
                    name="{{$name['district']}}"
                    data-district="{{ $value['district']??'' }}"
            ></select>&nbsp;
        </div>
        @include('admin::form.help-block')

    </div>
</div>
<script require="@sparkinzy.dcat-distpicker{{ $enable_select2?',@select2':''  }}" init="#{!! $id !!}">
    @if($enable_select2)
    $('[data-toggle=select2]').select2();
    @endif
</script>
