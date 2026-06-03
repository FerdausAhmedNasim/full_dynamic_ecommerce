<div>
    <div id="filterArea" class="d-inline-flex justify-content-start">
        <div class="col-md-4 col-sm-12" style="padding-left: 0 !important; padding-top: 10px; text-align: right">
            <span>Find Referral</span>
        </div>
        <div class="col-md-4 col-sm-12">
            <select wire:model="referralId" class="form-control" required>
                <option>Select Referral</option>
                @foreach($referrals as $referral)
                    <option value="{{ $referral->id }}">
                        R-{{ $referral->id }} - {{  $referral->client->user->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 col-sm-12"></div>
    </div>

    <div>       
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-5">
                            <div class="timeline">
                              @if ($data && count($data?->history))
                                @foreach($data?->history as $key => $history)
                                    @if ($history->action == 'Created')
                                        @php
                                            continue;
                                        @endphp
                                    @endif
                                    @if ($key%2 != 0)
                                        <div class="timeline-wrapper timeline-inverted timeline-wrapper-{{ \App\Library\Html::ReferralStatusClass($history->status) }}">
                                            <div class="timeline-badge"></div>
                                            <div class="timeline-panel" style="box-shadow: 1px 20px 35px 0 rgba(1, 1, 1, 0.1)!important;">
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">{{ $history->action }} - by {{ $history->user->full_name }}</h6>
                                            </div>
                                            <div class="timeline-body">
                                                @if ($history->status == \App\Library\Enum::REFERRAL_STATUS_DECLINED)
                                                    <p style="text-transform: capitalize"><strong>Dicline From</strong> - {{ $history->referral->declined_by }}</p>
                                                @endif

                                                @if ($history->status == 'Re-refer')
                                                    <p style="text-transform: capitalize"><strong>Referr To</strong> - {{ \App\Models\User::find(json_decode($history->changes)->after?->refer_to)->full_name }}</p>
                                                @endif
                                                <p>{{ $history->note }}</p>
                                            </div>
                                            <div class="timeline-footer d-flex align-items-center flex-wrap">
                                                <span class="font-weight-bold">{{ $history->created_at->format('d M Y H:i A') }}</span>
                                                @if ($history->status)
                                                    <span class="ml-md-auto">
                                                        {!! \App\Library\Html::ReferralStatusBadge($history->status) !!}
                                                    </span>
                                                @endif
                                            </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="timeline-wrapper timeline-wrapper-{{ \App\Library\Html::ReferralStatusClass($history->status) }}">
                                            <div class="timeline-badge"></div>
                                            <div class="timeline-panel" style="box-shadow: 1px 20px 35px 0 rgba(1, 1, 1, 0.1)!important;">
                                            <div class="timeline-heading">
                                                <h6 class="timeline-title">{{ $history->action }} - by {{ $history->user->full_name }}</h6>
                                            </div>
                                            <div class="timeline-body">
                                                @if ($history->status == \App\Library\Enum::REFERRAL_STATUS_DECLINED)
                                                    <p style="text-transform: capitalize"><strong>Dicline From</strong> - {{ $history->referral->declined_by }}</p>
                                                @endif

                                                @if ($history->status == 'Re-refer')
                                                    <p style="text-transform: capitalize"><strong>Referr To</strong> - {{ \App\Models\User::find(json_decode($history->changes)->after?->refer_to)->full_name }}</p>
                                                @endif
                                                <p>{{ $history->note }}</p>
                                            </div>
                                            <div class="timeline-footer d-flex align-items-center flex-wrap">
                                                <span class="font-weight-bold">{{ $history->created_at->format('d M Y H:i A') }}</span>
                                                @if ($history->status)
                                                    <span class="ml-md-auto">
                                                        {!! \App\Library\Html::ReferralStatusBadge($history->status) !!}
                                                    </span>
                                                @endif
                                            </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                              @endif
                            </div>

                            @if ($data)
                                <div class="timeline-wrapper timeline-wrapper-success row">
                                    <div class="timeline-panel col-md-4 offset-4" style="box-shadow: #e4e4e4 1px 20px 35px !important; padding: 20px; border-top: 2px solid #a3a4a5;">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title font-weight-bold">Created - by {{ $data->operator->full_name }}</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p><strong>Client Name</strong> - {{ $data->client->user->full_name }}</p>
                                        <p><strong>Referral Type</strong>  - {{ $data->referral_employee_id ? 'Internal' : 'External' }}</p>
                                        <p><strong>Service</strong> - {{ $data->service->name }}</p>
                                        <p><strong>Referral To</strong> - {{ $data->referTo->user->full_name}}</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <span class="font-weight-bold">{{ $data->created_at->format('d M Y H:i A') }}</span>
                                        <div class="ml-md-auto badge badge-secondary">Pending</div>
                                    </div>
                                    </div>
                                </div>
                            @endif

                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>