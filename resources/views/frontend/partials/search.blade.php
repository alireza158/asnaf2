@if ($frontendVariant === 'compact')
<div id="headerSearchPanel" class="header-search-panel" hidden>
  <form class="header-search-form" role="search">
    <input id="siteSearchInput" class="header-search-input" type="search" placeholder="جستجو در سایت…" autocomplete="off"/>
  </form>
  <div class="header-search-results" aria-live="polite"></div>
</div>
@else
<div class="header-search-panel site-container" hidden="" id="headerSearchPanel">
<form autocomplete="off" class="header-search-form" role="search">
<label class="header-search-label" for="siteSearchInput">جستجو در سایت</label>
<div class="header-search-field">
<input id="siteSearchInput" placeholder="عبارت مورد نظر را وارد کنید..." type="search"/>
<button type="submit">جستجو</button>
</div>
<div aria-live="polite" class="header-search-results"></div>
</form>
</div>
@endif
