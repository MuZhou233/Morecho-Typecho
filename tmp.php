array(29) {
  [0]=>
  array(28) {
    ["index"]=>
    array(6) {
      ["url"]=>
      string(1) "/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(8) "|^[/]?$|"
      ["format"]=>
      string(1) "/"
      ["params"]=>
      array(0) {
      }
    }
    ["archive"]=>
    array(6) {
      ["url"]=>
      string(6) "/blog/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(13) "|^/blog[/]?$|"
      ["format"]=>
      string(6) "/blog/"
      ["params"]=>
      array(0) {
      }
    }
    ["do"]=>
    array(6) {
      ["url"]=>
      string(22) "/action/[action:alpha]"
      ["widget"]=>
      string(9) "Widget_Do"
      ["action"]=>
      string(6) "action"
      ["regx"]=>
      string(32) "|^/action/([_0-9a-zA-Z-]+)[/]?$|"
      ["format"]=>
      string(10) "/action/%s"
      ["params"]=>
      array(1) {
        [0]=>
        string(6) "action"
      }
    }
    ["post"]=>
    array(6) {
      ["url"]=>
      string(63) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/[slug].html"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(55) "|^/([0-9]{4})/([0-9]{2})/([0-9]{2})/([^/]+)\.html[/]?$|"
      ["format"]=>
      string(17) "/%s/%s/%s/%s.html"
      ["params"]=>
      array(4) {
        [0]=>
        string(4) "year"
        [1]=>
        string(5) "month"
        [2]=>
        string(3) "day"
        [3]=>
        string(4) "slug"
      }
    }
    ["attachment"]=>
    array(6) {
      ["url"]=>
      string(26) "/attachment/[cid:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(28) "|^/attachment/([0-9]+)[/]?$|"
      ["format"]=>
      string(15) "/attachment/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(3) "cid"
      }
    }
    ["category"]=>
    array(6) {
      ["url"]=>
      string(17) "/category/[slug]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(25) "|^/category/([^/]+)[/]?$|"
      ["format"]=>
      string(13) "/category/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "slug"
      }
    }
    ["tag"]=>
    array(6) {
      ["url"]=>
      string(12) "/tag/[slug]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(20) "|^/tag/([^/]+)[/]?$|"
      ["format"]=>
      string(8) "/tag/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "slug"
      }
    }
    ["author"]=>
    array(6) {
      ["url"]=>
      string(22) "/author/[uid:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(24) "|^/author/([0-9]+)[/]?$|"
      ["format"]=>
      string(11) "/author/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(3) "uid"
      }
    }
    ["search"]=>
    array(6) {
      ["url"]=>
      string(19) "/search/[keywords]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(23) "|^/search/([^/]+)[/]?$|"
      ["format"]=>
      string(11) "/search/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(8) "keywords"
      }
    }
    ["index_page"]=>
    array(6) {
      ["url"]=>
      string(21) "/page/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(22) "|^/page/([0-9]+)[/]?$|"
      ["format"]=>
      string(9) "/page/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "page"
      }
    }
    ["archive_page"]=>
    array(6) {
      ["url"]=>
      string(26) "/blog/page/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(27) "|^/blog/page/([0-9]+)[/]?$|"
      ["format"]=>
      string(14) "/blog/page/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "page"
      }
    }
    ["category_page"]=>
    array(6) {
      ["url"]=>
      string(32) "/category/[slug]/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(34) "|^/category/([^/]+)/([0-9]+)[/]?$|"
      ["format"]=>
      string(16) "/category/%s/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(4) "slug"
        [1]=>
        string(4) "page"
      }
    }
    ["tag_page"]=>
    array(6) {
      ["url"]=>
      string(27) "/tag/[slug]/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(29) "|^/tag/([^/]+)/([0-9]+)[/]?$|"
      ["format"]=>
      string(11) "/tag/%s/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(4) "slug"
        [1]=>
        string(4) "page"
      }
    }
    ["author_page"]=>
    array(6) {
      ["url"]=>
      string(37) "/author/[uid:digital]/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(33) "|^/author/([0-9]+)/([0-9]+)[/]?$|"
      ["format"]=>
      string(14) "/author/%s/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(3) "uid"
        [1]=>
        string(4) "page"
      }
    }
    ["search_page"]=>
    array(6) {
      ["url"]=>
      string(34) "/search/[keywords]/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(32) "|^/search/([^/]+)/([0-9]+)[/]?$|"
      ["format"]=>
      string(14) "/search/%s/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(8) "keywords"
        [1]=>
        string(4) "page"
      }
    }
    ["archive_year"]=>
    array(6) {
      ["url"]=>
      string(18) "/[year:digital:4]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(19) "|^/([0-9]{4})[/]?$|"
      ["format"]=>
      string(4) "/%s/"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "year"
      }
    }
    ["archive_month"]=>
    array(6) {
      ["url"]=>
      string(36) "/[year:digital:4]/[month:digital:2]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(30) "|^/([0-9]{4})/([0-9]{2})[/]?$|"
      ["format"]=>
      string(7) "/%s/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(4) "year"
        [1]=>
        string(5) "month"
      }
    }
    ["archive_day"]=>
    array(6) {
      ["url"]=>
      string(52) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(41) "|^/([0-9]{4})/([0-9]{2})/([0-9]{2})[/]?$|"
      ["format"]=>
      string(10) "/%s/%s/%s/"
      ["params"]=>
      array(3) {
        [0]=>
        string(4) "year"
        [1]=>
        string(5) "month"
        [2]=>
        string(3) "day"
      }
    }
    ["archive_year_page"]=>
    array(6) {
      ["url"]=>
      string(38) "/[year:digital:4]/page/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(33) "|^/([0-9]{4})/page/([0-9]+)[/]?$|"
      ["format"]=>
      string(12) "/%s/page/%s/"
      ["params"]=>
      array(2) {
        [0]=>
        string(4) "year"
        [1]=>
        string(4) "page"
      }
    }
    ["archive_month_page"]=>
    array(6) {
      ["url"]=>
      string(56) "/[year:digital:4]/[month:digital:2]/page/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(44) "|^/([0-9]{4})/([0-9]{2})/page/([0-9]+)[/]?$|"
      ["format"]=>
      string(15) "/%s/%s/page/%s/"
      ["params"]=>
      array(3) {
        [0]=>
        string(4) "year"
        [1]=>
        string(5) "month"
        [2]=>
        string(4) "page"
      }
    }
    ["archive_day_page"]=>
    array(6) {
      ["url"]=>
      string(72) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(55) "|^/([0-9]{4})/([0-9]{2})/([0-9]{2})/page/([0-9]+)[/]?$|"
      ["format"]=>
      string(18) "/%s/%s/%s/page/%s/"
      ["params"]=>
      array(4) {
        [0]=>
        string(4) "year"
        [1]=>
        string(5) "month"
        [2]=>
        string(3) "day"
        [3]=>
        string(4) "page"
      }
    }
    ["comment_page"]=>
    array(6) {
      ["url"]=>
      string(53) "[permalink:string]/comment-page-[commentPage:digital]"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(36) "|^(.+)/comment\-page\-([0-9]+)[/]?$|"
      ["format"]=>
      string(18) "%s/comment-page-%s"
      ["params"]=>
      array(2) {
        [0]=>
        string(9) "permalink"
        [1]=>
        string(11) "commentPage"
      }
    }
    ["feed"]=>
    array(6) {
      ["url"]=>
      string(20) "/feed[feed:string:0]"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(4) "feed"
      ["regx"]=>
      string(17) "|^/feed(.*)[/]?$|"
      ["format"]=>
      string(7) "/feed%s"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "feed"
      }
    }
    ["feedback"]=>
    array(6) {
      ["url"]=>
      string(31) "[permalink:string]/[type:alpha]"
      ["widget"]=>
      string(15) "Widget_Feedback"
      ["action"]=>
      string(6) "action"
      ["regx"]=>
      string(29) "|^(.+)/([_0-9a-zA-Z-]+)[/]?$|"
      ["format"]=>
      string(5) "%s/%s"
      ["params"]=>
      array(2) {
        [0]=>
        string(9) "permalink"
        [1]=>
        string(4) "type"
      }
    }
    ["page"]=>
    array(6) {
      ["url"]=>
      string(12) "/[slug].html"
      ["widget"]=>
      string(14) "Widget_Archive"
      ["action"]=>
      string(6) "render"
      ["regx"]=>
      string(22) "|^/([^/]+)\.html[/]?$|"
      ["format"]=>
      string(8) "/%s.html"
      ["params"]=>
      array(1) {
        [0]=>
        string(4) "slug"
      }
    }
    ["commentToMailProcessQueue"]=>
    array(6) {
      ["url"]=>
      string(27) "/commentToMailProcessQueue/"
      ["widget"]=>
      string(20) "CommentToMail_Action"
      ["action"]=>
      string(12) "processQueue"
      ["regx"]=>
      string(34) "|^/commentToMailProcessQueue[/]?$|"
      ["format"]=>
      string(27) "/commentToMailProcessQueue/"
      ["params"]=>
      array(0) {
      }
    }
    ["MailValidateAction_Verify"]=>
    array(6) {
      ["url"]=>
      string(20) "/MailValidate/verify"
      ["widget"]=>
      string(19) "MailValidate_Action"
      ["action"]=>
      string(6) "action"
      ["regx"]=>
      string(28) "|^/MailValidate/verify[/]?$|"
      ["format"]=>
      string(20) "/MailValidate/verify"
      ["params"]=>
      array(0) {
      }
    }
    ["MailValidateAction_Send"]=>
    array(6) {
      ["url"]=>
      string(18) "/MailValidate/send"
      ["widget"]=>
      string(19) "MailValidate_Action"
      ["action"]=>
      string(4) "send"
      ["regx"]=>
      string(26) "|^/MailValidate/send[/]?$|"
      ["format"]=>
      string(18) "/MailValidate/send"
      ["params"]=>
      array(0) {
      }
    }
  }
  ["index"]=>
  array(3) {
    ["url"]=>
    string(1) "/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive"]=>
  array(3) {
    ["url"]=>
    string(6) "/blog/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["do"]=>
  array(3) {
    ["url"]=>
    string(22) "/action/[action:alpha]"
    ["widget"]=>
    string(9) "Widget_Do"
    ["action"]=>
    string(6) "action"
  }
  ["post"]=>
  array(3) {
    ["url"]=>
    string(63) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/[slug].html"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["attachment"]=>
  array(3) {
    ["url"]=>
    string(26) "/attachment/[cid:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["category"]=>
  array(3) {
    ["url"]=>
    string(17) "/category/[slug]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["tag"]=>
  array(3) {
    ["url"]=>
    string(12) "/tag/[slug]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["author"]=>
  array(3) {
    ["url"]=>
    string(22) "/author/[uid:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["search"]=>
  array(3) {
    ["url"]=>
    string(19) "/search/[keywords]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["index_page"]=>
  array(3) {
    ["url"]=>
    string(21) "/page/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_page"]=>
  array(3) {
    ["url"]=>
    string(26) "/blog/page/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["category_page"]=>
  array(3) {
    ["url"]=>
    string(32) "/category/[slug]/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["tag_page"]=>
  array(3) {
    ["url"]=>
    string(27) "/tag/[slug]/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["author_page"]=>
  array(3) {
    ["url"]=>
    string(37) "/author/[uid:digital]/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["search_page"]=>
  array(3) {
    ["url"]=>
    string(34) "/search/[keywords]/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_year"]=>
  array(3) {
    ["url"]=>
    string(18) "/[year:digital:4]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_month"]=>
  array(3) {
    ["url"]=>
    string(36) "/[year:digital:4]/[month:digital:2]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_day"]=>
  array(3) {
    ["url"]=>
    string(52) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_year_page"]=>
  array(3) {
    ["url"]=>
    string(38) "/[year:digital:4]/page/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_month_page"]=>
  array(3) {
    ["url"]=>
    string(56) "/[year:digital:4]/[month:digital:2]/page/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["archive_day_page"]=>
  array(3) {
    ["url"]=>
    string(72) "/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["comment_page"]=>
  array(3) {
    ["url"]=>
    string(53) "[permalink:string]/comment-page-[commentPage:digital]"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["feed"]=>
  array(3) {
    ["url"]=>
    string(20) "/feed[feed:string:0]"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(4) "feed"
  }
  ["feedback"]=>
  array(3) {
    ["url"]=>
    string(31) "[permalink:string]/[type:alpha]"
    ["widget"]=>
    string(15) "Widget_Feedback"
    ["action"]=>
    string(6) "action"
  }
  ["page"]=>
  array(3) {
    ["url"]=>
    string(12) "/[slug].html"
    ["widget"]=>
    string(14) "Widget_Archive"
    ["action"]=>
    string(6) "render"
  }
  ["commentToMailProcessQueue"]=>
  array(3) {
    ["url"]=>
    string(27) "/commentToMailProcessQueue/"
    ["widget"]=>
    string(20) "CommentToMail_Action"
    ["action"]=>
    string(12) "processQueue"
  }
  ["MailValidateAction_Verify"]=>
  array(3) {
    ["url"]=>
    string(20) "/MailValidate/verify"
    ["widget"]=>
    string(19) "MailValidate_Action"
    ["action"]=>
    string(6) "action"
  }
  ["MailValidateAction_Send"]=>
  array(3) {
    ["url"]=>
    string(18) "/MailValidate/send"
    ["widget"]=>
    string(19) "MailValidate_Action"
    ["action"]=>
    string(4) "send"
  }
}
