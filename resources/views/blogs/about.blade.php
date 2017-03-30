
<div class="row poster">
    <div class="col-xs-3">
        <div id="photo-header" class="text-center">
            <div id="photo">
                <img src="{{ URL::asset(isset($userresume['picture']) ? $userresume['picture'] : 'images/blue_logo_150x150.jpg') }}" alt="avatar">
            </div>
            <div id="text-header">
                <h1 class="etext"  nid='{{ @$userresumeid['name'] }}' ntype="name" >{{ @$userresume['name'] }}</h1>
                <span class="etext"  nid='{{ @$userresumeid['label'] }}' ntype="label" >
                    {{ @$userresume['label'] }}
                    ( {{ implode(' / ',$user->like) }} )
                </span>
            </div>
        </div>
    </div>
    <!-- ABOUT ME -->
    <div class="about col-xs-9 box">
        {{--<h2><i class="fa fa-user ico"></i> @lang('view.About')</h2>--}}
        <p class="etextarea"  nid='{{ @$userresumeid['summary'] }}' ntype="summary" >{{ @$userresume['summary'] }}</p>
        <p title="@lang('view.Fifty thousand meters - your values, principles and goals, this is the soul of your work')">
            <strong>@lang('view.Principles'): </strong><span class="etextarea"  nid='{{ @$userresumeid['principle'] }}' ntype="principle" >{{ @$userresume['principle'] }}</span></p>
        <p title="@lang('view.Forty thousand M - 3~5 year goal, can be a position, can also be organizational capabilities, coordination, etc.')">
            <strong>@lang('view.Vision'): </strong><span class="etextarea"  nid='{{ @$userresumeid['vision'] }}' ntype="vision" >{{ @$userresume['vision'] }}</span></p>
        <p title="@lang('view.Thirty thousand meters - more refined than the vision, usually a year of phased results')">
            <strong>@lang('view.Aim'): </strong><span class="etextarea"  nid='{{ @$userresumeid['aim'] }}' ntype="aim" >{{ @$userresume['aim'] }}</span></p>
        <p title="@lang('view.Twenty thousand meters - the role of work, such as researcher, manager, etc.; the role of life, such as father and son, children, etc.')">
            <strong>@lang('view.Duty'): </strong><span class="etextarea"  nid='{{ @$userresumeid['duty'] }}' ntype="duty" >{{ @$userresume['duty'] }}</span></p>
        <p title="@lang('view.Ten thousand meters - everything that needs to be done more than one step is a task')">
            <strong>@lang('view.Task'): </strong><span class="etextarea"  nid='{{ @$userresumeid['task'] }}' ntype="task" >{{ @$userresume['task'] }}</span></p>
        <p title="@lang('view.The runway - all the minor details events, we will put all of them into the list, one by one to get things done')">
            <strong>@lang('view.Actions'): </strong>@lang('view.See calendar for details. (need to Login, otherwise not visible)')</p>
    </div>
</div>