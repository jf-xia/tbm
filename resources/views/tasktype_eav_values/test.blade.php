


<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/_all-skins.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/gta.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2-bootstrap.min.css') }}">

<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/icheck.min.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/i18n/zh-CN.js') }}"></script>


    <section class="content-header">
        <h1 class="pull-left">@lang('view.Tasktype Eav Values')</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

    @include('flash::message')

    <select class="js-example-data-ajax form-control" >
        <option value="3620194" selected="selected">select2/select2</option>
        <option value="39320581"></option>
    </select>


    <script type="text/javascript">

        function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

            if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                    "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                    "</div>" +
                    "</div></div>";

            return markup;
        }

        function formatRepoSelection (repo) {
            return repo.full_name || repo.text;
        }

        $(document).ready(function() {
            $(".js-example-data-ajax").select2({
                ajax: {
                    url: "https://api.github.com/search/repositories",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 1,
                templateResult: formatRepo
            });

        });
    </script>


    </div>