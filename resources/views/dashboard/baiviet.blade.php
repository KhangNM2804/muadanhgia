@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title"><?= __('labels.share_every_day') ?></h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless table-vcenter mt-5">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 33%;"><?= __('labels.post_title') ?></th>
                                    <th class="d-none d-xl-table-cell"><?= __('labels.create_date') ?></th>
                                    <th class="d-none d-xl-table-cell"><?= __('labels.update_date') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($posts)
                                    @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{route('posts.show', ['slug' => $post->slug])}}">
                                                <i class="far fa fa-file-alt"></i> {{$post->title}}
                                            </a>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{$post->created_at}}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{$post->updated_at}}
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $posts->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
@endsection