"use strict";

var indexTemplate = "<article class=\"py-8 horizontal-card border-celeste border-b-2\">\n  {{#newsImageSrc}}\n    <figure class=\"w-full h-48 sm:h-64 p-4 bg-celeste relative z-0 flex items-center justify-center mb-4 lg:mb-0\">\n      <img src=\"{{ newsImageSrc }}\" class=\"object-fit-cover absolute h-full w-full inset-0\" alt=\"\">\n    </figure>\n  {{/newsImageSrc}}\n  {{^newsImageSrc}}\n    <figure class=\"w-full h-48 sm:h-64 p-4 bg-celeste relative z-0 flex items-center justify-center mb-4 lg:mb-0\">\n      <div class=\"text-camouflage-green opacity-75 fill-current h-full p-12\">\n        <img src=\"/assets/img/icon-newspaper.svg\" class=\"h-full\" alt=\"\">\n      </div>\n    </figure>\n  {{/newsImageSrc}}\n  <div>\n    <h2 class=\"text-2xl mt-4 sm:mt-0\">\n      <a href=\"/{{ url }}\">\n        {{{_highlightResult.title.value}}}\n      </a>\n    </h2>\n    <div class=\"text-shark my-4\">\n      {{#summary}}\n        {{{_highlightResult.summary.value}}}\n      {{/summary}}\n      {{^summary}}\n        {{{_snippetResult.body.value}}}{{^_snippetResult.body}}\u2026{{/_snippetResult.body}}\n      {{/summary}}\n    </div>\n    <div>\n      <a aria-label=\"Continue reading {{ title }}\" href=\"/{{ url }}\">Read More \xBB</a>\n    </div>\n  </div>\n</article>";