
@foreach(\App\Models\Permission::where('is_menu','=',1)->orderBy('orderby','ASC')->get() as $menu)
    @if($menu->route=='break')
        <li class="header {!! $mclass = $menu->name !!}" onclick="javascript:$('.menu{{ $mclass }}').toggle();">{!! $menu->display_name !!}<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></li>
    @elseif(Auth::user()->can($menu->name))
        <?php
            $active='';
            $route = Request::route()->getName();
            $isTaskset=(explode('tsets.',$menu->name));
            if ($route){
                $action = explode('.',$route)[1];
                if(isset($isTaskset[1]) && \Request::route()->getParameter('tasktype')==$isTaskset[1] && $route == $menu->route ){
                    $active = 'active';
                }else if(!isset($isTaskset[1])&&$route == $menu->route){
                    $active = 'active';
                }else if(($action=='show'||$action=='create'||$action=='edit')&&explode('.',$route)[0].'.index'==$menu->route){
                    $active = 'active';
                }
            }
        ?>
        <li class="menu{{ $mclass }} {{ $active }}">
            <a href="{!! isset($isTaskset[1])?route($menu->route,$isTaskset[1]):route($menu->route) !!}"><i class="fa fa-circle-o"></i><span>{!! $menu->display_name !!}</span></a>
        </li>
    @endif
@endforeach

