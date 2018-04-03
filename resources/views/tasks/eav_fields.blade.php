@foreach($atts1 as $attribute)
    <div class="form-group col-sm-{{ $attribute->frontend_size }}">
        <label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}</label>
    <?php
        $type=$attribute->frontend_input;
        $select=explode('2',$type); $htmlClass=['class' => 'form-control'];
        if ($attribute->is_required==1) {
            $htmlClass['required']='required';
        }
        $option=explode('|',$attribute->option);
        if (!isset($eavValue1[$attribute->id])){
            $eavValue1[$attribute->id]=null;
        }
    ?>
    @if($type=='select')
        {!! Form::select('attribute['.$attribute->id.']',array_combine($option,$option), $eavValue1[$attribute->id], $htmlClass) !!}
    @elseif($select[0]=='select')
        <?php
            $htmlClass['class']=$htmlClass['class'].' select2-ajax-'.$select[1];
            $userName=$eavValue1[$attribute->id]&&$eavValue1[$attribute->id]>0?(\App\User::find($eavValue1[$attribute->id],['name'])->name):null; ?>
        {!! Form::select('attribute['.$attribute->id.']', [$eavValue1[$attribute->id]=>$userName], $eavValue1[$attribute->id], $htmlClass) !!}
        @section('scripts')
            <script type="text/javascript">
                select2(".select2-ajax-{{ $select[1] }}", "/tasks/{{ $select[1] }}ajaxlist");
            </script>
        @endsection
    @else
        {!! Form::$type('attribute['.$attribute->id.']', $eavValue1[$attribute->id], $htmlClass) !!}
    @endif
    </div>
@endforeach