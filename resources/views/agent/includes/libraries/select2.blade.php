@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // loop all .select 
            $(".select2").each(function(){
                var uri = $(this).data('uri')
                if(uri != ""){
                    $(this).select2({
                        theme: 'bootstrap-5',
                    })
                }else{
                    $(this).select2({
                        theme: 'bootstrap-5',
                        width: 'resolve',
                        placeholder: 'Please select one',
                        allowClear: true,
                        ajax: {
                            delay: 250,
                            url: uri,
                            dataType: 'json',
                            delay: 500,
                            data: function(params) {
                                return {
                                    searchTerm: params.term // search term
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    })
                }
                
            })

            $(".select2-modal").each(function(){
                var uri = $(this).data('uri')
                $(this).select2({
                    theme: "bootstrap-5",
                    dropdownParent: $('#modalWithSelect2'),
                    width: 'resolve',
                    allowClear: true,
                    ajax: {
                        delay: 250,
                        url: uri,
                        dataType: 'json',
                        delay: 500,
                        data: function(params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    }
                })
            })
        });
    </script>
@endpush