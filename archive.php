---
layout: default
---

<!-- 
Credits: this page borrowed a lot from:
https://github.com/kitian616/jekyll-TeXt-theme
-->

<div id='tag_cloud' class="tags js-tags">
    <a class="tag-button--all" data-encode="">
        Show All
        <sup>{{site.posts.size}}</sup>
    </a>

    {% capture tags %}
    {% for tag in site.tags %}
    <a data-sort="{{ site.posts.size | minus: tag[1].size | prepend: '0000' | slice: -4, 4 }}"
        data-encode="{{ tag[0] | strip | url_encode }}" class="tag-button" title="{{ tag[0] }}" rel="{{ tag[1].size }}">
        {{ tag[0] }}
        <sup>{{tag[1].size}}</sup>
    </a>
    {% endfor %}
    {% endcapture %}
    {{ tags | split:'</a>' | sort | join:'</a>' }}
    </a>
</div>

<div class="archive timeline">
    <div class="js-result d-none">
        {%- assign _sorted_list = site.posts -%}
        {%- assign _sorted_list = _sorted_list | sort: 'date' -%}
        {%- assign _sorted_list = _sorted_list | reverse -%}


        {%- for _article in _sorted_list -%}
            {%- assign _tags = '' -%}
            {%- for _tag in _article.tags -%}
                {%- assign _tag_encode = _tag | strip | url_encode -%}
                {%- if forloop.last -%}
                    {%- assign _tags = _tags | append: _tag_encode -%}
                    {%- else -%}
                    {%- assign _tags = _tags | append: _tag_encode | append: ',' -%}
                {%- endif -%}
            {%- endfor -%}

            {% comment %} group by year {% endcomment %}
            {%- assign _currentdate = _article.date | date: '%Y年%m月' -%}
            {%- if _currentdate != _date -%}
                {%- unless forloop.first -%}
                </section>
                {%- endunless -%}
                <section>
                <div class="tl-head">
                    <div class="tl-title">{{ _currentdate }}</div>
                </div>
                {%- assign _date = _currentdate -%}
            {%- endif -%}

            <div class="post-preview item tl-item" data-tags="{{ _tags }}">
                <div class="tl-date">{{ _article.date | date: "%d日" }}</div>
                <div class="tl-body">
                    <div class="tl-content">
                        <a href="{{ _article.url | prepend: site.baseurl }}">
                            <h2 class="post-title">
                                {% if _article.copyright %}「转载」{% endif %}
                                {{ _article.title }}
                            </h2>
                            {% if _article.subtitle %}
                                <h3 class="post-subtitle">
                                    {{ _article.subtitle }}
                                </h3>
                            {% endif %}
                        </a>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
    <div class="tl-head">
        <div class="tl-title bg-white" style="color: #777;">BEGIN</div>
    </div>
</div>

<style>
    .archive{
        padding: 1rem;
    }
    .archive.timeline{
        margin-left: 3rem;
    }
    .timeline .tl-title{
        color: #fff;
    }
    .archive .post-title{
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 0;
    }
    .archive .post-subtitle{
        font-size: 0.9rem;
        margin-top: .2em;
        margin-bottom: 0;
    }
    body{
        overflow-y: scroll;
    }
</style>