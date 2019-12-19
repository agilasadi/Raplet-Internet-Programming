@if(Auth::check())



    <div class="commentSectionOuther">
        <div class="commentSection @if(count($comments) < 1) youMakeTheFirstStep @endif">


            <div class="customTextareaStopFading">
                <div>
                    @if(Auth::check())
                        <div class="">
                            <div class="form-group commentTextareField transitionSlow">
                                                <textarea class="transitionSlow" id="commentContent" maxlength="2840"
                                                          placeholder="{{ trans('home.addcomment') }}"
                                                          rows="3"></textarea>
                                <div class="commentSubmitBtnIcons">
                                    <div class="d-none bg-white linkers-container mb-2 position-relative">
                                        <div class="linkenterence" id="addlink">
                                            <input class="niceShapedLinkin " id="linkentered"
                                                   placeholder="{{ trans('home.addlink') }}">
                                            <input class="niceShapedLinkin " id="linkenteredl"
                                                   placeholder="{{ trans('home.visualname') }}">
                                            <button class="niceShapedLinkin addtheextra transitionSlow"
                                                    data-type="l" data-idlinker="linkentered"><i
                                                        class="fas fa-link"></i>&nbsp;&nbsp;{{ trans('home.add') }}
                                            </button>
                                        </div>
                                        <div class="linkenterence" id="addvideolink">
                                            <input class="niceShapedLinkin " id="videoentered"
                                                   placeholder="{{ trans('home.addvideolink') }}">
                                            <input class="niceShapedLinkin " id="videoenteredv"
                                                   placeholder="{{ trans('home.visualname') }}">
                                            <button class="niceShapedLinkin addtheextra transitionSlow"
                                                    data-type="v" data-idlinker="videoentered"><i
                                                        class="fas fa-play"></i>&nbsp;&nbsp;{{ trans('home.add') }}
                                            </button>
                                        </div>
                                        <div class="linkenterence" id="starttyping">
                                            <input class="niceShapedLinkin " id="typingentered"
                                                   placeholder="{{ trans('home.starttyping') }}">
                                            <button class="niceShapedLinkin addtheextra transitionSlow"
                                                    data-type="t" data-idlinker="typingentered"><i
                                                        class="fas fa-hashtag"></i>&nbsp;&nbsp;{{ trans('home.add') }}
                                            </button>
                                        </div>
                                        <button class="closeLinkersDiv"><i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-primary shadowingBtn characteristicButtonHover characteristicSubmitButton"
                                            data-content_id="{{ $post->id }}" type="button"
                                            id="submitComment"
                                            style="margin-right: 9px">{{ trans('home.submit') }}</button>
                                    <button class="checkSomethingOut activateAnonymous"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="{{ trans('home.toggleHidden')}}"><i
                                                class="fas fa-user-secret"></i></button>

                                    <button class="characteristicButton transitionSlow addonbtns"
                                            data-content_name="addlink"><i class="fas fa-link"></i>
                                    </button>
                                    <button class="characteristicButton transitionSlow addonbtns"
                                            data-content_name="addvideolink"><i
                                                class="fas fa-video"></i></button>
                                    <button class="characteristicButton transitionSlow addonbtns"
                                            data-content_name="starttyping"><i
                                                class="fas fa-hashtag"></i>
                                    </button>
                                    <small class="isitanonymous d-none pl-2">
                                        <i class="fas fa-user-secret"></i>&nbsp;&nbsp;
                                    </small>
                                    <button class="linkerObjectCounter">
                                        <i class="fas fa-external-link-square-alt"></i>&nbsp;&nbsp;<span
                                                id="linkerObjectCounter">5</span>
                                    </button>
                                </div>
                                <div class="manageCommentSection">
                                    <button class="mangerToglingDot float-right transitionSlow">
                                        <i class="fas fa-chevron-down"></i></button>
                                    <div class="managerButtons float-right">
                                        <button id="clearCommentText" class="border-right-line">
                                            <i class="fas fa-backspace"></i></button>

                                    </div>
                                </div>
                            </div>
                            <div class="extrasContainerList">
                                <ul class="extraContentBead"></ul>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center">{{ trans('home.loginToComment') }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@else
    <div class="commentOutherBeforePlaceholder" style="display: block;">
        <div class="commentBeforePlaceholder @if($comments != null) noCommentsHere @endif">

            <div class="form-group">
                <input type="text" class="form-control pullUpLogin transitionSlow" data-toggle="modal"
                       data-target="#loginModel" placeholder="{{ trans('home.loginToComment') }}">
            </div>
            <button class="commentBeforeFieldButtonPreview"><i class="fas fa-paperclip"></i></button>
        </div>
    </div>
@endif
