<div class="information-box">
    <div class="question-list" style="padding-right: 20px;">
        <h3 class="mb-4">Question And Answer</h3>
        <div class="customer-question">
            @foreach ($customer_questions as $customer_question)
            <div class="py-2 border-1 border-top rounded-3">
                <div class="people-box">
                    <div>
                        <div class="people-image people-text">
                            <svg viewBox="115 120 33 35.34" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                xmlns:bx="https://boxy-svg.com">
                                <g>
                                    <path
                                        style="stroke: rgb(53, 53, 53); transform-box: fill-box; transform-origin: 50% 50%; fill: rgb(7, 157, 223);"
                                        d="M 118 120 H 142 A 6 6 0 0 1 148 126 V 150 H 118 V 120 Z"
                                        bx:shape="rect 118 120 30 30 0 6 0 0 1@62db7f42" />
                                </g>
                                <g>
                                    <polyline style="stroke: rgb(27, 24, 24); fill: rgb(7, 157, 223);"
                                        points="118.824 141 115 155.34 126.472 147.692" />
                                </g>
                                <g>
                                    <text
                                        style="fill: rgb(255, 255, 255); font-family: Roboto; font-size: 22px; white-space: pre;"
                                        x="126.195" y="142.674">Q</text>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="people-comment">
                        <div class="people-name">
                            <div class="name">{{$customer_question->customer?->full_name}}<span
                                    class="text-secondary ms-2" style="font-size: 10px">{{$customer_question?->created_at->format('d-m-Y H:I A')}}</span></div>
                        </div>
                        <div class="reply">
                            <p class="m-0 text-secondary">{{$customer_question->comment}}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    @if ($customer_question->childrenQuestion)
                        <div class="people-box">
                            <div>
                                <div class="people-image people-text">
                                    <svg viewBox="115 120 33 35.34" width="25" height="25"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
                                        <g>
                                            <path
                                                style="stroke: rgb(53, 53, 53); fill: rgb(102, 102, 102); transform-box: fill-box; transform-origin: 50% 50%;"
                                                d="M 118 120 H 142 A 6 6 0 0 1 148 126 V 150 H 118 V 120 Z"
                                                bx:shape="rect 118 120 30 30 0 6 0 0 1@62db7f42" />
                                        </g>
                                        <g>
                                            <polyline style="stroke: rgb(27, 24, 24); fill: rgb(102, 102, 102);"
                                                points="118.824 141 115 155.34 126.472 147.692" />
                                        </g>
                                        <g>
                                            <text
                                                style="fill: rgb(255, 255, 255); font-family: Roboto; font-size: 22px; white-space: pre;"
                                                x="126.195" y="142.674">A</text>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="people-comment">
                                <div class="people-name">
                                    <div class="name">
                                        {{ $customer_question->childrenQuestion->seller?->full_name }}<span
                                            class="text-secondary ms-2"
                                            style="font-size: 10px">{{ $customer_question?->childrenQuestion?->created_at?->format('d-m-Y H:I A') }}</span></div>
                                </div>
                                <div class="reply">
                                    <p class="m-0 text-secondary">{{$customer_question->childrenQuestion->comment}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <span class="text-secondary">No answer yet</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @php
        $totalProductQuestion = App\Models\ProductQuestion::whereNotNull("parent_id")->where('product_id',
        $product->id)->count();
        @endphp
        {{-- @if ($totalProductQuestion > 0)
        <h4 class="mb-3" id="question_answers_count">Ther questions answered by <span>{{ $product->seller->full_name
                }}</span> <span>({{$totalProductQuestion}})</span></h4>
        @endif --}}
        <div id="question-container">

        </div>

        @if ($totalProductQuestion >= 4)
        <button id="load-more-btn" class="btn btn-sm p-0 fw-bold theme-color bg-transparent">Load More...</button>
        @endif

    </div>
    @auth
    <div class="qa-box">
        <h4 class="mb-3" style="border-bottom: 1px solid #dee2e6; padding-bottom: 1.6rem;">Ask Your Question</h4>

        <label for="content" class="form-label">Write Your Question *</label>
        <textarea id="content" rows="3" class="form-control content" name="comment" placeholder="Your Question"
            required></textarea>
        <input type="text" class="d-none product_id" name="product_id" value="{{ $product->id }}">
        <input type="text" class="d-none customer_id" name="customer_id" value="{{ authUser()->id }}">
        <button type="submit" class="btn btn-sm mt-3 fw-bold text-light theme-bg-color question-btn">Ask
            Question</button>
    </div>
    @endauth

    @guest
    <div class="qa-box">
        <h4 class="mb-3" style="border-bottom: 1px solid #dee2e6; padding-bottom: 1.6rem;">Ask Your Question</h4>
        <p>Please login to ask your question.</p>
    </div>
    @endguest
</div>
