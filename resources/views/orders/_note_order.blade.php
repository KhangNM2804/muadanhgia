<div class="block block-rounded block-bordered">
    <div class="block-header block-header-default bg-primary">
        <h4 class="block-title text-white"><?= __('labels.note_type') ?></h4>
        <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
                    class="si si-arrow-up"></i></button>
        </div>
    </div>
    <div class="block-content">
        {{ $description }}
    </div>
</div>
