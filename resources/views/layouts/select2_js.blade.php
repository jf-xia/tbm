<script type="text/javascript">
    function select2(classh,ajaxUrl,tag,placeholder){
        if(!tag){tag=false;}
        $(classh).select2({
            placeholder: '@lang('view.Enter Text to Search')'+placeholder,
            ajax: {
                dataType: 'json',
                theme: "bootstrap",
                url: '{{ url('') }}'+ajaxUrl,
                delay: 400,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                    //console.log(data);
                    return {
                        results: data
                    };
                }
            },
            minimumInputLength: 2,
            tags: tag,
            theme: "bootstrap",
            language: "zh-CN",
            escapeMarkup: function (markup) { return markup; },
            templateResult: formatRepo
        });
    }
    function formatRepo (repo) {
        var markup = "<div>" + repo.text + "</div>";

        if (repo.descr) {
            markup += "<div>" + repo.descr + "</div>";
        }

        return markup;
    }
</script>