<?php
    if (!isset($stask)) $stask=$task;
    $atts=$atts->taskTypeEav($stask->tasktype_id);
    $eavValue=$eavValue->eavValue($stask->id);
?>
@if($atts)
    @foreach($atts as $attribute)
        <div class="form-group col-sm-{{ $attribute->frontend_size }} widget">
            <h5 class="wlabel"><b><label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}</label></b></h5>
            <?php
            $type=$attribute->frontend_input;
            $select=explode('2',$type);
            ?>
            @if(count($select)>1)
                <h5 class="wvalue">{!! isset($eavValue[$attribute->id])&&$eavValue[$attribute->id]>0 ? \App\User::find($eavValue[$attribute->id],['name'])->name : null !!}</h5>
            @elseif($attribute->frontend_label=='SKU')
                <h5 class="wvalue"><a target="_blank" href="https://item.jd.com/{!! $eavValue[$attribute->id] !!}.html" alt="SKU" >{!! $eavValue[$attribute->id] !!}</a></h5>
            @elseif($type=='image')
                <h5 class="wvalue"><img src="{!! $eavValue[$attribute->id] !!}" alt="Image" /></h5>
            @else
                <h5 class="wvalue">{!! $attribute->frontend_size==12?
                '<textarea rows="5" style="width: 100%;" disabled="disabled">'.(isset($eavValue[$attribute->id]) ? $eavValue[$attribute->id] : null).'</textarea>':
                (isset($eavValue[$attribute->id]) ? $eavValue[$attribute->id] : null) !!}</h5>
            @endif
        </div>
    @endforeach
@endif

<!-- Content Field -->
<div class="form-group col-sm-12 widget">
    <b>@lang('db.content')</b><br/>
    {!! $stask->content !!}
</div>