<style type="text/css">
    [data-toggle="distpicker"] .select2-container {
        width: 100% !important;
    }
    .no-padding{
        padding-left: 0;
        padding-right: 0;
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
            <div class="row-fluid input-group-append" style="margin-left: 0;width: 90%">
                <div class="col no-padding">
                    <select data-toggle="select2"
                            class="form-control {{$selectIds['province']}}"
                            style="width: 100%;"
                            name="{{$name['province']}}"
                            data-province="{{ $value[$name['province']]??'' }}"
                    ></select>
                </div>
                @if($level > 1)
                    <div class="col no-padding">
                        <select data-toggle="select2"
                                class="form-control {{$selectIds['city']}}"
                                name="{{$name['city']}}"
                                data-city="{{ $value[$name['city']]??'' }}"
                        ></select>
                    </div>
                @endif
                @if($level > 2)
                    <div class="col no-padding">
                        <select data-toggle="select2"
                                class="form-control {{$selectIds['district']}}"
                                name="{{$name['district']}}"
                                data-district="{{ $value[$name['district']]??'' }}"
                        ></select>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    Dcat.ready(function () {
        $('[data-toggle=select2]').select2({
            width:'100%'
        });
    });
</script>
