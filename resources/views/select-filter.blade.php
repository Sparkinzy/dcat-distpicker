<style type="text/css">
    .input-group .select2-container {
        width: auto !important;
    }
</style>
<div class="filter-input col-sm-{{ $width }}">
    <div class="form-group">
        <div data-toggle="distpicker"
             @if($data_value_type)
             data-value-type="{{ $data_value_type }}"
             @endif
             class="input-group input-group-sm"
             id="{{ $distpickerId }}">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white text-capitalize "><b>{!! $label !!}</b></span>
            </div>
            <select data-toggle="select2"
                    class="form-control {{$selectIds['province']}}"
                    name="{{$name['province']}}"
                    data-province="{{ $value[$name['province']]??'' }}"
            ></select>
            @if($level > 1)
                <select data-toggle="select2"
                        class="form-control {{$selectIds['city']}}"
                        name="{{$name['city']}}"
                        data-city="{{ $value[$name['city']]??'' }}"
                ></select>
            @endif
            @if($level > 2)
                <select data-toggle="select2"
                        class="form-control {{$selectIds['district']}}"
                        name="{{$name['district']}}"
                        data-district="{{ $value[$name['district']]??'' }}"
                ></select>
            @endif
        </div>
    </div>
</div>

<script>
    Dcat.ready(function () {
        $('[data-toggle=select2]').select2();
    });
</script>
