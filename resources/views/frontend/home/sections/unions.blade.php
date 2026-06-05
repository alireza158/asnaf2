<section class="representatives-section section-white" id="representatives">
    <div class="site-container">
        <div class="section-heading"><h2>{{ $section->title }}</h2><a class="tab-pill" href="{{ route('guilds.index') }}">فهرست اتحادیه‌ها</a></div>
        <div aria-label="نماینده‌ها" class="tabs" data-tab-group="representatives" role="tablist">
            <button class="tab-pill active" data-tab-target="rep-production" type="button">اتحادیه‌های تولیدی</button>
            <button class="tab-pill" data-tab-target="rep-distribution" type="button">اتحادیه‌های توزیعی</button>
            <button class="tab-pill" data-tab-target="rep-service" type="button">اتحادیه‌های خدماتی</button>
        </div>
        <div class="tab-panels" data-tab-panels="representatives">
            @foreach([
                'rep-production' => ['title' => 'اتحادیه‌های تولیدی شهرستان گرگان', 'alt' => 'اتحادیه‌های تولیدی', 'type' => 'production', 'items' => $productionUnions ?? collect()],
                'rep-distribution' => ['title' => 'اتحادیه‌های توزیعی شهرستان گرگان', 'alt' => 'اتحادیه‌های توزیعی', 'type' => 'distribution', 'items' => $distributionUnions ?? collect()],
                'rep-service' => ['title' => 'اتحادیه‌های خدماتی شهرستان گرگان', 'alt' => 'اتحادیه‌های خدماتی', 'type' => 'service', 'items' => $serviceUnions ?? collect()],
            ] as $panel => $data)
                <div class="tab-panel {{ $loop->first ? 'active' : '' }}" data-tab-panel="{{ $panel }}">
                    <div class="representative-layout">
                        <div class="representative-map">
                            <button class="soft-button map-badge">{{ $data['title'] }}</button>
                            <img alt="{{ $data['alt'] }}" class="map-img" src="{{ asset('assets/img/asnaf-gorgan-default.jpg') }}">
                        </div>

                        <aside class="people-panel" data-search-area>
                            <div class="searchbox">
                                <span class="search-icon"></span>
                                <input data-filter-input data-union-search-url="{{ route('guilds.search') }}" data-union-type="{{ $data['type'] }}" placeholder="جستجوی سریع اتحادیه..." type="search">
                            </div>

                            <div class="people-scroll-wrap">
                                <ul class="person-list" data-union-results>
                                    @forelse($data['items'] as $union)
                                        <li>
                                            <a href="{{ route('guilds.show', $union->slug) }}" class="d-flex align-items-center gap-2 text-decoration-none">
                                                <span class="person-avatar avatar-{{ ($loop->iteration % 6) + 1 }}"></span>
                                                <div>
                                                    <strong>{{ $union->display_title }}</strong>
                                                    <small>{{ $union->short_description ?: $union->manager_name ?: $union->union_type_label }}</small>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li>
                                            <span class="person-avatar avatar-1"></span>
                                            <div>
                                                <strong>اتحادیه‌ای ثبت نشده است</strong>
                                                <small>لطفاً از پنل مدیریت اتحادیه جدید ثبت کنید.</small>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
