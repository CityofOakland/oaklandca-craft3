(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{2:function(e,t,s){e.exports=s("gOQl")},3:function(e,t){},4:function(e,t){},5:function(e,t){},6:function(e,t){},gOQl:function(e,t,s){"use strict";s.r(t);s("HEbw");var a=instantsearch({appId:"6V5VJO8ZG2",apiKey:"9bded46d3070b2089499c70b2389708b",indexName:"production_calendars",searchParameters:{highlightPreTag:'<b class="font-bold"><em>',highlightPostTag:"</em></b>"}}),n=instantsearch({appId:"6V5VJO8ZG2",apiKey:"9bded46d3070b2089499c70b2389708b",indexName:"production_documents",searchParameters:{highlightPreTag:'<b class="font-bold"><em>',highlightPostTag:"</em></b>",hitsPerPage:10}}),l=instantsearch({appId:"6V5VJO8ZG2",apiKey:"9bded46d3070b2089499c70b2389708b",indexName:"production_government",searchParameters:{highlightPreTag:'<b class="font-bold"><em>',highlightPostTag:"</em></b>"}}),i=instantsearch({appId:"6V5VJO8ZG2",apiKey:"9bded46d3070b2089499c70b2389708b",indexName:"production_all",searchParameters:{highlightPreTag:'<b class="font-bold"><em>',highlightPostTag:"</em></b>"},routing:!0,searchFunction:function(e){var t=i.helper.state.query,s=i.helper.state.page;l.helper.setQuery(t),l.helper.setPage(s),l.helper.search(),a.helper.setQuery(t),a.helper.setPage(s),a.helper.search(),n.helper.setQuery(t),n.helper.setPage(s),n.helper.search(),e.search()}});i.addWidget(instantsearch.widgets.searchBox({container:"#search-input",placeholder:"Search"})),i.addWidget(instantsearch.widgets.pagination({container:"#bottom-pagination",padding:5,scrollTo:!1,cssClasses:{root:"p-0 inline-block",disabled:"w-0"}})),i.addWidget(instantsearch.widgets.hits({container:"#all-hits",templates:{empty:"No results",item:'\n      <div>\n        <h3 class="text-lg mb-2"><a class="hover:bg-bright-green hover:text-white" href="{{ url }}">{{{_highlightResult.title.value}}}</a></h3>\n\n        <p class="text-sm my-0">\n          {{{ _snippetResult.leadIn.value }}}\n        </p>\n\n        {{{ #summary }}}\n          <p class="text-sm my-0">\n            {{{ _snippetResult.summary.value }}}\n          </p>\n        {{{ /summary }}}\n        {{ ^summary }}\n          <p class="text-sm my-0">\n            {{{ _snippetResult.body.value }}}\n          </p>\n        {{{ /summary }}}\n\n        <p class="text-sm my-0">\n          {{{ _snippetResult.bio.value }}}\n        </p>\n      </div>\n      '},cssClasses:{root:"block"}})),l.addWidget(instantsearch.widgets.hits({container:"#gov-hits",templates:{empty:"No results",item:'\n        <h3 class="text-lg mb-2"><a class="block hover:bg-bright-green hover:text-white" href="{{ url }}">{{{_highlightResult.title.value}}}</a></h3>\n        {{{ #bio }}}\n          <p class="text-sm my-0">\n            {{{ _snippetResult.bio.value }}}\n          </p>\n        {{{ /bio }}}\n        {{{ #about }}}\n          <p class="text-sm my-0">\n            {{{ _snippetResult.about.value }}}\n          </p>\n        {{{ /about }}}\n        {{{ #leadIn }}}\n          <p class="text-sm my-0">\n            {{{ _snippetResult.leadIn.value }}}\n          </p>\n        {{{ /leadIn }}}\n      '},cssClasses:{root:"block"}})),n.addWidget(instantsearch.widgets.hits({container:"#doc-hits",templates:{empty:"No results",item:'\n      <article class="text-sm mb-6">\n        <h3 class="text-base my-0 leading-normal mb-2"><a class="block hover:bg-bright-green hover:text-white" href="{{ url }}">{{{_highlightResult.title.value}}}</a></h3>\n        {{ ^leadIn }}\n          <p class="my-0">\n            {{{ _snippetResult.leadIn.value }}}\n          </p>\n        {{{ /summary }}}\n        {{ ^documents }}\n          <p class="my-0">\n            {{{ _snippetResult.summary.value }}}\n          </p>\n        {{{ /documents }}}\n      </article>\n      '},cssClasses:{root:"block"}})),a.addWidget(instantsearch.widgets.hits({container:"#cal-hits",templates:{empty:"No results",item:'\n        <article class="text-xs md:text-sm">\n          <h3 class="text-base my-2"><a class="block hover:bg-bright-green hover:text-white" href="{{ url }}">{{{_highlightResult.title.value}}}</a></h3>\n          {{{ #body }}}\n            <p class="mt-0 mb-2">\n              {{{ _snippetResult.body.value }}}\n            </p>\n          {{{ /body }}}\n        </article>\n      '},cssClasses:{root:"block"}})),n.start(),a.start(),l.start(),i.start();var r=Array.from(document.querySelectorAll("a[data-holder]")),c=Array.from(document.querySelectorAll("[data-hits]"));r.forEach(function(e){!function(e){e.addEventListener("click",function(e){e.preventDefault(),r.forEach(function(e){e.classList.remove("active")}),e.target.classList.add("active");var t=e.target.dataset.holder;c.forEach(function(e){e.id==t?e.classList.remove("hidden"):e.classList.add("hidden")})})}(e)})}},[[2,0,1]]]);
//# sourceMappingURL=search.js.map