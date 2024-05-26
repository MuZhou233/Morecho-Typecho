/*!
 * jquery.tagcloud.js
 * A Simple Tag Cloud Plugin for JQuery
 *
 * https://github.com/addywaddy/jquery.tagcloud.js
 * created by Adam Groves
 */
(function($) {
  /*global jQuery*/
  "use strict";

  var compareWeights = function(a, b) {
    return a - b;
  };

  // Converts hex to an RGB array
  var toRGB = function(code) {
    if (code.length === 4) {
      code = code.replace(/(\w)(\w)(\w)/gi, "$1$1$2$2$3$3");
    }
    var hex = /(\w{2})(\w{2})(\w{2})/.exec(code);
    return [parseInt(hex[1], 16), parseInt(hex[2], 16), parseInt(hex[3], 16)];
  };

  // Converts an RGB array to hex
  var toHex = function(ary) {
    return (
      "#" +
      jQuery
        .map(ary, function(i) {
          var hex = i.toString(16);
          hex = hex.length === 1 ? "0" + hex : hex;
          return hex;
        })
        .join("")
    );
  };

  var colorIncrement = function(color, range) {
    return jQuery.map(toRGB(color.end), function(n, i) {
      return (n - toRGB(color.start)[i]) / range;
    });
  };

  var tagColor = function(color, increment, weighting) {
    var rgb = jQuery.map(toRGB(color.start), function(n, i) {
      var ref = Math.round(n + increment[i] * weighting);
      if (ref > 255) {
        ref = 255;
      } else {
        if (ref < 0) {
          ref = 0;
        }
      }
      return ref;
    });
    return toHex(rgb);
  };

  $.fn.tagcloud = function(options) {
    var opts = $.extend({}, $.fn.tagcloud.defaults, options);
    var tagWeights = this.map(function() {
      return $(this).attr("rel");
    });
    tagWeights = jQuery.makeArray(tagWeights).sort(compareWeights);
    var lowest = tagWeights[0];
    var highest = tagWeights.pop();
    var range = highest - lowest;
    if (range === 0) {
      range = 1;
    }
    // Sizes
    var fontIncr, colorIncr;
    if (opts.size) {
      fontIncr = (opts.size.end - opts.size.start) / range;
    }
    // Colors
    if (opts.color) {
      colorIncr = colorIncrement(opts.color, range);
    }
    return this.each(function() {
      var weighting = $(this).attr("rel") - lowest;
      if (opts.size) {
        $(this).css({
          "font-size": opts.size.start + weighting * fontIncr + opts.size.unit
        });
      }
      if (opts.color) {
        $(this).css({
          "background-color": tagColor(opts.color, colorIncr, weighting)
        });
      }
    });
  };

  $.fn.tagcloud.defaults = {
    size: { start: 14, end: 18, unit: "pt" }
  };
})(jQuery);

/*
Credits: this script is borrowed from
https://github.com/kitian616/jekyll-TeXt-theme
*/
(function() {
  function queryString() {
    // This function is anonymous, is executed immediately and
    // the return value is assigned to QueryString!
    var i = 0,
      queryObj = {},
      pair;
    var queryStr = window.location.search.substring(1);
    var queryArr = queryStr.split("&");
    for (i = 0; i < queryArr.length; i++) {
      pair = queryArr[i].split("=");
      // If first entry with this name
      if (typeof queryObj[pair[0]] === "undefined") {
        queryObj[pair[0]] = pair[1];
        // If second entry with this name
      } else if (typeof queryObj[pair[0]] === "string") {
        queryObj[pair[0]] = [queryObj[pair[0]], pair[1]];
        // If third or later entry with this name
      } else {
        queryObj[pair[0]].push(pair[1]);
      }
    }
    return queryObj;
  }

  var setUrlQuery = (function() {
    var baseUrl = window.location.href.split("?")[0];
    return function(query) {
      if (typeof query === "string") {
        window.history.replaceState(null, "", baseUrl + query);
      } else {
        window.history.replaceState(null, "", baseUrl);
      }
    };
  })();

  $(document).ready(function() {
    var $tags = $(".js-tags");
    var $articleTags = $tags.find(".tag-button");
    var $tagShowAll = $tags.find(".tag-button--all");
    var $result = $(".js-result");
    var $sections = $result.find("section");
    var sectionArticles = [];
    var $lastFocusButton = null;
    var sectionTopArticleIndex = [];
    var hasInit = false;

    $sections.each(function() {
      sectionArticles.push($(this).find(".item"));
    });

    function init() {
      var i,
        index = 0;
      for (i = 0; i < $sections.length; i++) {
        sectionTopArticleIndex.push(index);
        index += $sections.eq(i).find(".item").length;
      }
      sectionTopArticleIndex.push(index);
    }

    function searchButtonsByTag(_tag /*raw tag*/) {
      if (!_tag) {
        return $tagShowAll;
      }
      var _buttons = $articleTags.filter('[data-encode="' + _tag + '"]');
      if (_buttons.length === 0) {
        return $tagShowAll;
      }
      return _buttons;
    }

    function buttonFocus(target) {
      if (target) {
        target.addClass("focus");
        $lastFocusButton &&
          !$lastFocusButton.is(target) &&
          $lastFocusButton.removeClass("focus");
        $lastFocusButton = target;
      }
    }

    function tagSelect(tag /*raw tag*/, target) {
      var result = {},
        $articles;
      var i, j, k, _tag;

      for (i = 0; i < sectionArticles.length; i++) {
        $articles = sectionArticles[i];
        for (j = 0; j < $articles.length; j++) {
          if (tag === "" || tag === undefined) {
            result[i] || (result[i] = {});
            result[i][j] = true;
          } else {
            var tags = $articles
              .eq(j)
              .data("tags")
              .split(",");
            for (k = 0; k < tags.length; k++) {
              if (tags[k] === tag) {
                result[i] || (result[i] = {});
                result[i][j] = true;
                break;
              }
            }
          }
        }
      }

      for (i = 0; i < sectionArticles.length; i++) {
        result[i] && $sections.eq(i).removeClass("d-none");
        result[i] || $sections.eq(i).addClass("d-none");
        for (j = 0; j < sectionArticles[i].length; j++) {
          if (result[i] && result[i][j]) {
            sectionArticles[i].eq(j).removeClass("d-none");
          } else {
            sectionArticles[i].eq(j).addClass("d-none");
          }
        }
      }

      hasInit || ($result.removeClass("d-none"), (hasInit = true));

      if (target) {
        buttonFocus(target);
        _tag = target.attr("data-encode");
        if (_tag === "" || typeof _tag !== "string") {
          setUrlQuery();
        } else {
          setUrlQuery("?tag=" + _tag);
        }
      } else {
        buttonFocus(searchButtonsByTag(tag));
      }
    }

    function tagDetailSelect(tag) {
      $(".tagDetail").addClass("d-none");
      $("[data-tag='" + tag + "']").removeClass("d-none");
    }

    var query = queryString(),
      _tag = query.tag;

    init();
    tagSelect(_tag);
    tagDetailSelect(_tag);

    $tags.on("click", "a", function() {
      /* only change */
      tagSelect($(this).data("encode"), $(this));
      tagDetailSelect($(this).data("encode"));
    });
  });
})();

$(function(){
  var classes = ['bg-info','bg-success','bg-warning','bg-danger','bg-default','bg-primary'];
  $('.archive.timeline section').each(function(i){
    $(this).find('.tl-title').addClass(classes[i % classes.length])
    $(this).find('.tl-body').addClass(classes[i % classes.length])
  })
})