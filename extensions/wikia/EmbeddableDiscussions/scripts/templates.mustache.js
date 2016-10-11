/* jshint ignore:start */ define( 'embeddablediscussions.templates.mustache', [], function() { 'use strict'; return {
    "DiscussionError" : '<p class="error widget-discussions-error">{{errorMessage}}</p>',"DiscussionThreadDesktop" : '<section class="module embeddable-discussions-module"><div class="embeddable-discussions-heading-container"><div class="embeddable-discussions-heading">{{heading}}</div>{{#editText}}<a href="#" class="embeddable-discussions-edit">{{editText}}{{{editIcon}}}</a>{{/editLink}}<div class="embeddable-discussions-show-all"><a href="{{discussionsUrl}}">{{showAll}}</a></div></div><div class="embeddable-discussions-threads {{columnsWrapperClass}}" data-requestData="{{requestData}}"data-requestUrl="{{requestUrl}}">{{loading}}</div></section>',"DiscussionThreadMobile" : '<div data-component="widget-discussions" data-attrs="{{mercuryComponentAttrs}}">{{loading}}</div>',"DiscussionThreads" : '{{#threads}}<div class="embeddable-discussions-post-detail {{isDeleted}} {{isReported}} {{columnsDetailsClass}}"><div class="embeddable-discussions-side-spaced"><a href="{{link}}" class="embeddable-discussions-fill-div"></a><div id="post-{{id}}" class="embeddable-discussions-header-container"><div class="avatar-container">{{#authorAvatar}}<a href="/wiki/User:{{author}}"><img src="{{authorAvatar}}" class="avatar" alt="{{author}}"></a>{{/authorAvatar}}{{^authorAvatar}}<div class="embeddable-discussions-default-avatar"></div>{{/authorAvatar}}</div><div class="avatar-details"><a class="avatar-username" href="/wiki/User:{{author}}">{{author}}</a><span class="embeddable-discussions-timestamp" title="{{timestamp}}">• {{createdAt}}</span></div></div><div class="embeddable-discussions-title {{isDeleted}}">{{title}}</div><div class="embeddable-discussions-content {{isDeleted}} clamp">{{content}}</div><div class="embeddable-discussions-forum">{{forumName}}</div><div class="embeddable-discussions-post-counters"><span class="embeddable-discussions-post-counter"><img class="svg embeddable-discussions-upvote-icon-tiny" src="{{upvoteTinyIconSrc}}" width="14" height="16">{{upvoteCount}}</span><span class="embeddable-discussions-post-counter"><img class="svg embeddable-discussions-reply-icon-tiny" src="{{replyTinyIconSrc}}" width="14" height="16">{{commentCount}}</span></div></div><div><ul class="embeddable-discussions-post-actions"><li class="embeddable-discussions-upvote-area">{{#hasUpvoted}}<a href="{{upvoteUrl}}" class="upvote" data-id="{{firstPostId}}" data-hasUpvoted="1"><img class="svg embeddable-discussions-upvote-icon-active" src="{{upvoteIconSrc}}" width="24" height="22">{{upvoteText}}</a>{{/hasUpvoted}}{{^hasUpvoted}}<a href="{{upvoteUrl}}" class="upvote" data-id="{{firstPostId}}" data-hasUpvoted="0"><img class="svg embeddable-discussions-upvote-icon" src="{{upvoteIconSrc}}" width="24" height="22">{{upvoteText}}</a>{{/hasUpvoted}}</li><li class="embeddable-action-gap"></li><li class="embeddable-discussions-replies-area"><a href="{{link}}"><img class="svg embeddable-discussions-reply-icon" src="{{replyIconSrc}}" width="24" height="22">{{replyText}}</a></li></ul></div></div>{{/threads}}{{^threads}}<div class="embeddable-discussions-zero"><svg class="embeddable-discussions-zero-plus"></svg><div class="embeddable-discussions-zero-text"><div>{{zeroText}}</div><div>{{zeroTextDetail}}</div></div></div>{{/threads}}',"SettingsModal" : '<h1 class="embeddable-discussions-settingsmodal-heading">{{heading}}</h1><div class="embeddable-discussions-settingsmodal-wrapper"><div>{{description}}</div><div><h2 class="embeddable-discussions-settingsmodal-subheading">{{sortBy}}</h2><div class="embeddable-discussions-settingsmodal-sort-container"><div class="embeddable-discussions-settingsmodal-sort-item embeddable-discussions-settingsmodal-sort-item-left" id="embeddable-discussions-settingsmodal-sort-latest">{{latest}}</div><div class="embeddable-discussions-settingsmodal-sort-item" id="embeddable-discussions-settingsmodal-sort-trending">{{trending}}</div></div></div><div><div class="embeddable-discussions-settingsmodal-filter-by">{{filterBy}}</div><ul class="embeddable-discussions-filter-by-list"><li class="embeddable-discussions-filter-by-item">{{#allChecked}}<input type="checkbox" id="embeddable-discussions-settingsmodal-filter-by-all-checkbox" value="all" checked>{{filterByAll}}{{/allChecked}}{{^allChecked}}<input type="checkbox" id="embeddable-discussions-settingsmodal-filter-by-all-checkbox" value="all">{{filterByAll}}{{/allChecked}}</li>{{#categories}}<li class="embeddable-discussions-filter-by-item">{{#checked}}<input value="{{id}}" type="checkbox" checked>{{name}}{{/checked}}{{^checked}}<input value="{{id}}" type="checkbox">{{name}}{{/checked}}</li>{{/categories}}</ul></div></div><div class="embeddable-discussions-settingsmodal-buttonrow"><a href="#" class="embeddable-discussions-settingsmodal-button" id="embeddable-discussions-settingsmodal-done">{{done}}</a><a href="#" class="embeddable-discussions-settingsmodal-button" id="embeddable-discussions-settingsmodal-cancel">{{cancel}}</a></div>',"ShareModal" : '<div class="embeddable-discussions-sharemodal-heading">{{heading}}</div><div class="embeddable-discussions-sharemodal-icons">{{#icons}}<a target="_blank" href="{{url}}"><div class="embeddable-discussions-sharemodal-icon embeddable-discussions-icon-{{icon}}"></div></a>{{/icons}}</div><div class="embeddable-discussions-sharemodal-buttonrow"><a href="#" class="embeddable-discussions-sharemodal-cancel-button">{{close}}</a></div>',
    "done": "true"
  }; }); /* jshint ignore:end */