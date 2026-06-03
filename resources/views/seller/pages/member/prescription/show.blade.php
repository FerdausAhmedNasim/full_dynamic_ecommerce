<div class="card shadow-sm">
    <div class="card-body py-sm-4">

        <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab"
                    aria-controls="pills-home" aria-selected="true">Timeline</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab"
                    aria-controls="pills-profile" aria-selected="false">Attachments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab"
                    aria-controls="pills-contact" aria-selected="false">Private</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-my-notes-tab" data-bs-toggle="pill" href="#pills-my-notes" role="tab"
                    aria-controls="pills-my-notes" aria-selected="false">My Notes</a>
            </li>
        </ul>
        <hr>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @include('seller.pages.member.prescription.partials.show.timeline')
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                 @include('seller.pages.member.prescription.partials.show.attachment')
            </div>

            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                @include('seller.pages.member.prescription.partials.show.private')
            </div>

            <div class="tab-pane fade" id="pills-my-notes" role="tabpanel" aria-labelledby="pills-my-notes-tab">
                @include('seller.pages.member.prescription.partials.show.mynote')
            </div>

        </div>
    </div>
</div>
