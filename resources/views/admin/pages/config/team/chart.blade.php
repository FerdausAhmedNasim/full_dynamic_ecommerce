@extends('admin.layouts.master')

@section('title', __('Organisational Chart'))

@section('content')

    <div class="content-wrapper">

        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('admin.config.more_settings.index')) !!}
            <div class="d-block">
                <h4 class="content-title">{{ strtoupper(__('Organisational Chart')) }}</h4>
            </div>

        </div>

        <div class="card shadow-sm col-md-12">
            <div class="card-body py-sm-4">
                <div class="chart-container" style="height: 1000px;"></div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-org-chart@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>

    <script>
        $( document ).ready(function() {
            var chart;

            var teamData = <?php echo $team; ?>;

            chart = new d3.OrgChart()
                .container('.chart-container')
                .data(teamData)
                .rootMargin(100)
                .nodeWidth((d) => 210)
                .nodeHeight((d) => 140)
                .childrenMargin((d) => 130)
                .compactMarginBetween((d) => 75)
                .compactMarginPair((d) => 80)
                .linkUpdate(function(d, i, arr) {
                    d3.select(this)
                        .attr('stroke', (d) =>
                            d.data._upToTheRootHighlighted ? '#152785' : 'lightgray'
                        )
                        .attr('stroke-width', (d) =>
                            d.data._upToTheRootHighlighted ? 5 : 1.5
                        )
                        .attr('stroke-dasharray', '4,4');

                    if (d.data._upToTheRootHighlighted) {
                        d3.select(this).raise();
                    }
                })
                .nodeContent(function(d, i, arr, state) {
                    const colors = [
                        '#6E6B6F',
                        '#18A8B6',
                        '#F45754',
                        '#96C62C',
                        '#BD7E16',
                        '#802F74',
                    ];
                    const color = colors[d.depth % colors.length];
                    const imageDim = 65;
                    const lightCircleDim = 75;
                    const outsideCircleDim = 90;

                    return `
                        <div style="background-color:white; position:absolute;
                            width:${d.width}px;
                            height:${d.height}px;"
                        >
                            <div style="position:absolute;border-radius:100px;
                                background-color:${color};
                                margin-top:-${outsideCircleDim / 2}px;
                                margin-left:${d.width / 2 - outsideCircleDim / 2}px;
                                width:${outsideCircleDim}px;
                                height:${outsideCircleDim}px;">
                            </div>
                            <div style="background-color:#ffffff;position:absolute;border-radius:100px;
                                margin-top:-${lightCircleDim / 2}px;
                                margin-left:${d.width / 2 - lightCircleDim / 2}px;
                                width:${lightCircleDim}px;height:${lightCircleDim}px;">
                            </div>
                            <img src="${d.data.imageUrl}"
                                style="position:absolute;border-radius:100px;
                                margin-top:-${imageDim / 2}px;
                                margin-left:${d.width / 2 - imageDim / 2}px;
                                width:${imageDim}px;height:${imageDim}px;"
                            />
                            <div class="card" style="position:absolute;height:40px;background-color:#3AB6E3;
                                top:${outsideCircleDim / 2 + 2}px;
                                width:${d.width}px;"
                            >
                                <div class="sub-div" style="background-color:${color};text-align:center;padding-top:10px;color:#ffffff;font-weight:bold;font-size:16px">
                                    ${d.data.name}
                                </div>
                                <div class="sub-div" style="background-color:#F0EDEF;text-align:center;padding-top:10px;color:#424142;font-size:16px">
                                    ${d.data.jobTitle}
                                </div>
                                <div class="sub-div" style="background-color:#F0EDEF;text-align:center;padding-top:10px;color:#424142;font-size:16px">
                                    ${d.data.teamName}
                                </div>
                            </div>
                        </div>`;
                })
                .render();

        });
    </script>

    @endpush
