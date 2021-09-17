<style type="text/css">
    .input-group .select2-container{
        width: auto!important;
    }
</style>
<div class="filter-input col-sm-{{ $width }}"  >
    <div class="form-group" data-toggle="distpicker">
        <div class="input-group input-group-sm" id="{{ $id }}" >
            <div  class="input-group-prepend" >
                <span class="input-group-text bg-white text-capitalize "><b>{!! $label !!}</b></span>
            </div>
            <select data-toggle="select2" class="form-control" name="{{$name['province']}}" ></select>
            <select data-toggle="select2" class="form-control" name="{{$name['city']}}" ></select>
            <select data-toggle="select2" class="form-control" name="{{$name['district']}}"></select>
        </div>
    </div>
</div>

<script>
    Dcat.ready(function(){
        $('[data-toggle=select2]').select2();
    });
</script>
