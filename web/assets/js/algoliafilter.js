(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{1:function(t,e,a){t.exports=a("2eUe")},"2eUe":function(t,e){var a=document.getElementById("filter-reveal"),n=document.getElementById("algolia-filters"),i=["opacity-100","h-auto","z-40","visible"],s=["opacity-0","h-0","z-neg-10","invisible"];if(null!=a&&a.addEventListener("click",function(t){var e,o,d,r;(t.preventDefault(),n.classList.contains("opacity-0"))?((e=n.classList).add.apply(e,i),(o=n.classList).remove.apply(o,s),a.innerHTML="Hide Filters"):((d=n.classList).add.apply(d,s),(r=n.classList).remove.apply(r,i),a.innerHTML="Show Filters")},!1),window.section&&window.entryTitle)var o="".concat(window.section,":'").concat(window.entryTitle,"'");Math.round((new Date).getTime()/1e3);var d=instantsearch({appId:"6V5VJO8ZG2",apiKey:"9bded46d3070b2089499c70b2389708b",indexName:window.algoliaIndex,routing:!0,searchParameters:{snippetEllipsisText:"…",filters:o||void 0}});d.addWidget(instantsearch.widgets.analytics({pushFunction:function(t,e,a){window.ga("set","page",window.location.pathname+window.location.search),window.ga("send","pageView")}}));if(facetFilters.forEach(function(t){d.addWidget(instantsearch.widgets.menuSelect({container:t.container,attributeName:t.attribute,operator:"or",limit:10,templates:{header:t.header}}))}),"undefined"!=typeof moment){moment().format("L");var r=instantsearch.connectors.connectRange(function(t,e){if(e){var a=t.refine,n=new Date(moment().startOf("month")).getTime(),i=new Date(moment().endOf("month")).getTime();a([n,i]),new Calendar({element:$("#calendar"),same_day_range:!0,start_date:n,end_date:i,presets:[{label:"This month",start:moment().startOf("month"),end:moment().endOf("month")},{label:"Next month",start:moment().add(1,"month").startOf("month"),end:moment().add(1,"month").endOf("month")},{label:"Last month",start:moment().subtract(1,"month").startOf("month"),end:moment().subtract(1,"month").endOf("month")},{label:"Last year",start:moment().subtract(1,"year").startOf("year"),end:moment().subtract(1,"year").endOf("year")}],callback:function(){var t=new Date(this.start_date).getTime(),e=new Date(this.end_date).getTime();a([t,t===e?e+864e5-1:e])}})}})({attributeName:"date"});d.addWidget(r)}d.addWidget(instantsearch.widgets.searchBox({container:"#search-input",placeholder:window.searchInputText||"Search"})),d.addWidget(instantsearch.widgets.hits({container:"#hits",cssClasses:{root:window.hitsRootClass||"block"},templates:{empty:"No results",item:window.indexTemplate||'<article class="py-8 sm:py-12 border-gray-300 border-b-2">\n  {{#displayDate}}\n  <div class="text-base text-gray-400 mb-4">\n    Publish Date: <b>{{ displayDate }}</b>\n  </div>\n  {{/displayDate}}\n  <h2 class="text-xl md:text-xxl my-0 {{#leadIn}} mt-0 mb-3 md:mb-6 {{/leadIn}}">\n    <a href="/{{ url }}">\n      {{{ _highlightResult.title.value }}}\n    </a>\n  </h2>\n  {{#leadIn}}\n    <p class="text-base text-gray-700 md:text-lg my-2 md:my-4">\n      {{{ _highlightResult.leadIn.value }}}\n    </p>\n  {{/leadIn}}\n</article>'}})),d.addWidget(instantsearch.widgets.pagination({container:"#bottom-pagination",padding:5,scrollTo:!1,cssClasses:{root:"p-0 inline-block",disabled:"w-0"}})),d.start()}},[[1,0]]]);
//# sourceMappingURL=algoliafilter.js.map