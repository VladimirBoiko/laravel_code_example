@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

<!--Comments-->
@if($comments->total() > 0)
    <!-- COMMENTS PAGINATION TOP-->
    <div class="pagination-content"></div>
    <!-- END COMMENTS PAGINATION TOP-->

    <!-- COMMENTS CONTENT -->
    <div id="ajax_section_comments" data-pages="" data-comments-total="{{$comments->total()}}">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!-- END COMMENTS CONTENT -->

    <!-- COMMENTS PAGINATION BOTTOM -->
    <div class="pagination-content"></div>
    <!-- END COMMENTS PAGINATION BOTTOM-->
@else
    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Comments:</div>
        </div>
        <div class="col-md-12 comment-content-wrapper">
            <div class="comment-content">
                There are any comments
            </div>
        </div>
    </div>
@endif
<!--END Comments-->

@section('js')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>

    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>
    <script>
        $(function () {
            getSections(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                var page = $(this).attr('data-page');
                $('.load-wrapp').show();
                getSections(page);
            });
        });

        function getSections(page) {
            var container = $('#ajax_section_comments');
            $.get('{{route('comments.pagination',['object' => $object, 'id' => $id])}}' +
                '?page=' + page, {}, function (data) {
                container.html(data.comments);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of comments*/
                if (page !== 1) {
                    moveToTop(container);
                }
            })
        }

        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            /**custom commands for HTML text editor*/
            addCountries();
            addRaces();

            if ($('body').find('#comment-content').length > 0) {
                var textarea = document.getElementById('comment-content');

                sceditor.create(textarea, {
                    format: 'xhtml',
                    style: '{{route('home')}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route('home')}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time|' +
                    'countries|'+
                    'races',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection