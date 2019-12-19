@section('style')
    <link href="{{ asset('mycss/adminPanel.css') }}" rel="stylesheet">
@endsection
<div class="adminNavbarDiv">
       <a class="btn btn-btn-light @if(Request::url() == route('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
           <i class="fas fa-columns"></i>&nbsp;&nbsp;Dashboard
       </a>

       <a class="btn btn-btn-light @if(Request::url() == route('badgeCreator')) active @endif" href="{{ route('badgeCreator') }}">
           <i class="fas fa-certificate"></i>&nbsp;&nbsp;Badge Create
       </a>

       <a class="btn btn-btn-light @if(Request::url() == route('badgelist')) active @endif" href="{{ route('badgelist') }}">
           <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Badges List
       </a>

       <a class="btn btn-btn-light @if(Request::url() == route('badgetranslations')) active @endif" href="{{ route('badgetranslations') }}">
           <i class="fas fa-language"></i>&nbsp;&nbsp;Badges Translations
       </a>

       <a class="btn btn-btn-light @if(Request::url() == route('termstranslations')) active @endif" href="{{ route('termstranslations') }}">
           <i class="fas fa-balance-scale"></i>&nbsp;&nbsp;Privacy & Terms
       </a>

       <a class="btn btn-btn-light @if(Request::url() == route('keeperCreatePage') || Request::url() == route('keeperEditPage')) active @endif" href="{{ route('keeperCreatePage') }}">
           <i class="fas fa-comment-alt"></i>&nbsp;&nbsp;Notify People
       </a>
       <a class="btn btn-btn-light @if(Request::url() == route('indexCategories') || Request::url() == route('indexCategories')) active @endif" href="{{ route('indexCategories') }}">
           <i class="fas fa-stream"></i>&nbsp;&nbsp;Categories
       </a>
</div>