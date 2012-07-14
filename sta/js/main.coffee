g1001 =
  url:
    userInfo: 'http://api.in1001.com/v1/user/{0}?projection=fuller'
  pageId: $('body').attr('id')
  userId: $.cookie 'uid'
  user: null

$ ->
  $(document).ajaxError (e, jqxhr, settings, exception) ->
    if jqxhr.status == 401 then showSigninBox()
  loadUserInfo initFav

loadUserInfo = (callback) ->
  callback or= initFav
  if not g1001.userId then return
  $.ajax
    url: $.format g1001.url.userInfo, g1001.userId
    type: 'GET'
    dataType: 'jsonp'
    success: (data) ->
      g1001.user = data
      callback(data)

initFav = (user) ->
  for t in ['element', 'magazine', 'user']
    for id in user.fav["#{t}s"]
      $("##{t}_#{id}").addClass 'favorited'

showSigninBox = ->
  $.colorbox
        overlayClose: false
        fixed: true
        opacity: 0.5
        href: '/user/signinbox'
checkSignedIn = ->
  if $.cookie('nickname') then return true
  else
    showSigninBox()
    return false
getLikeUrl = (type, id, action) -> "/#{type}/#{id}/#{action}"
cancelLike = (type, type_id, where) ->
  if not checkSignedIn() then return
  action = if type == 'user' then 'unfollow' else 'cancelLike'
  $e = $("##{type}_#{type_id}")
  $.post(
    getLikeUrl(type, type_id, action),
    {dataType: 'json'},
    (data) ->
      if $.inArray(type, ['magazine', 'element']) >= 0
        window.location.reload()
      else if type == 'user'
        if where == 'user_center'
          $('div.userinfo a.follow').show()
          $('div.userinfo p.followed').hide()
        else if where  == 'user_center_followee'
          window.location.reload()
        else # detail
          $e.removeClass('favorited')
  )
like = (type, type_id, where) ->
  if not checkSignedIn() then return
  action = if type == 'user' then 'follow' else 'like'
  $e = $("#" + type + "_" + type_id)
  $.post(
    getLikeUrl(type, type_id, action),
    {dataType: 'json'},
    (data) ->
      if $.inArray(type, ['magazine', 'element']) >= 0
        if data.likes
          $e.addClass('favorited')
          $('a.like', $e).text data.likes
          $('span.favs', $e).text data.likes
      else if type == 'user'
        if data.status == 'success'
          if where == 'user_center'
            $('div.userinfo a.follow').hide()
            $('div.userinfo p.followed').show()
          else # detail
            $e.addClass('favorited')
  )
