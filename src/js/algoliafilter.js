const filterReveal = document.getElementById("filter-reveal");
const filters = document.getElementById("algolia-filters");
const openClasses = ["opacity-100", "h-auto", "z-40", "visible"];
const closedClasses = ["opacity-0", "h-0", "z-neg-10", "invisible"];

if (filterReveal != null) {
  filterReveal.addEventListener("click", function(e) {
    e.preventDefault();
  
    if (filters.classList.contains("opacity-0")) {
      filters.classList.add(...openClasses);
      filters.classList.remove(...closedClasses);
      filterReveal.innerHTML = "Hide Filters";
    } else {
      filters.classList.add(...closedClasses);
      filters.classList.remove(...openClasses);
      filterReveal.innerHTML = "Show Filters";
    }
  }, false);  
}

const ts = Math.round((new Date()).getTime() / 1000);
const search = instantsearch({
  appId: "6V5VJO8ZG2",
  apiKey: "9bded46d3070b2089499c70b2389708b",
  indexName: window.algoliaIndex,
  routing: true,
  searchParameters: {
    snippetEllipsisText: "…",

    // {% block filters %}
    //   {% if section is defined and slug is defined %}
    //       {% set facetItem = craft.entries.section(section).slug(slug).one().title %}
    //     filters: "{{ section }}:'{{ facetItem | replace({'%"%': '\\"', "%'%": "\'"}) }}'",
    //   {% endif %}
    // {% endblock %}
  },
});

const defaultTemplate = `<article class="py-8 sm:py-12 border-celeste border-b-2">
  {{#displayDate}}
  <div class="text-base text-camouflage-green mb-4">
    Publish Date: <b>{{ displayDate }}</b>
  </div>
  {{/displayDate}}
  <h3 class="text-xl md:text-2xl my-0 {{#leadIn}} mt-0 mb-3 md:mb-6 {{/leadIn}}">
    <a href="/{{ url }}">
      {{{ _highlightResult.title.value }}}
    </a>
  </h3>
  {{#leadIn}}
    <p class="text-base text-shark md:text-lg my-2 md:my-4">
      {{{ _highlightResult.leadIn.value }}}
    </p>
  {{/leadIn}}
</article>`;

facetFilters.forEach(facet => {
  search.addWidget(
    instantsearch.widgets.menuSelect({
      container: facet.container,
      attributeName: facet.attribute,
      operator: 'or',
      limit: 10,
      templates: {
        header: facet.header
      }
    })
  );    
});

if (typeof moment !== 'undefined') {
  const ONE_DAY_IN_MS = 3600 * 24 * 1000;

  const TODAY = moment().format('L'); 

  const datePicker = instantsearch.connectors.connectRange(
    (options, isFirstRendering) => {
      if (!isFirstRendering) return;

      const { refine } = options;

      new Calendar({
        element: $('#calendar'),
        same_day_range: true,
        presets: false,
        callback: function() {
          const start = new Date(this.start_date).getTime();
          const end = new Date(this.end_date).getTime();
          const actualEnd = start === end ? end + ONE_DAY_IN_MS - 1 : end;

          refine([start, actualEnd]);
        },
      });
    }
  );

  const dateRangeWidget = datePicker({
    attributeName: 'date',
  });
  
  search.addWidget(dateRangeWidget);
}

search.addWidget({
  render: function(data) {
    console.log(data);
  }
});

search.addWidget(
  instantsearch.widgets.searchBox({
    container: "#search-input",
    placeholder: window.searchInputText || "Search"
  })
);

search.addWidget(
  instantsearch.widgets.hits({
    container: "#hits",
    cssClasses: {
      root: window.hitsRootClass || "block"
    },
    templates: {
      empty: "No results",
      item: window.indexTemplate || defaultTemplate,
    }
  })
);

search.addWidget(
  instantsearch.widgets.pagination({
    container: "#bottom-pagination",
    padding: 5,
    // default is to scroll to 'body', here we disable this behavior
    scrollTo: false,
    cssClasses: {
      root: "p-0 inline-block",
      disabled: "w-0"
    }
  })
);

search.start();
