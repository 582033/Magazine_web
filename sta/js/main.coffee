g1001 = null
$ ->
  window.g1001 =
    url:
      userInfo: 'http://api.in1001.com/v1/user/{0}?projection=fuller'
    pageId: $('body').attr('id') or ''
    userId: $.cookie 'uid'
    user: null

  $(document).ajaxError (e, jqxhr, settings, exception) ->
    if jqxhr.status == 401 then showSigninBox()
  initHeader()
  initColorbox()
  loadUserInfo initUserInfo
  switch g1001.pageId
    when 'change-password' then initChangePassword()
    when 'mag_detail' then initDetail()

initHeader = ->
  $('div.log_reg a.login').click (ev) ->
    $('#loginTip').toggle()
    ev.stopPropagation()
  $('#loginTip').click (ev) -> ev.stopPropagation()
  $(document).click (ev) ->
    $('#loginTip').hide()

  nickname = $.cookie 'nickname'
  if nickname
    initUserInfo
        nickname: nickname
        image: $.cookie 'avatar'
initColorbox = ->
  opts =
    overlayClose: false
    fixed: true
    scrolling: false
    opacity: 0.5
    onCleanup: ->
      $e = $.colorbox.element()
      if $e.attr('href').match(/applyAuthor/) and $('#apply_author div.apply_ok').is(':visible')
        window.location.reload()

  $(document).on('click', 'a.thickbox', ->
    $(this).colorbox $.extend({}, opts, {open: true})
    return false
  )

initUserInfo = (user) ->
    avatar = user.image + '!50'
    $('div.self_info').show()
    $('div.log_reg').hide()
    $ui = $('div.self_info .user_info')
    if user.unreads
      $('div.self_info a.msg_tip').show().find('span').text(user.unreads)
    else
      $('div.self_info a.msg_tip').hide()
    $('span.nickname', $ui).text user.nickname
    $('img', $ui).attr 'src', avatar
    $('form#comment img.avatar').attr # form detail and comment page
        src: avatar
        alt: user.nickname
    if user.fav then initFav user
initDetail = ->
  page_height = $(".main").height()
  if $(".left_main").height() < page_height
    $(".left_main").css "height", page_height + "px"
  $li = $('.scrollbar li')
  $(".scrollbar ul").css("width", $li.outerWidth(true) * $li.size() + "px")
  $('.scrollbar').jScrollPane autoReinitialise: true

initChangePassword = ->
changePassword = (form) ->
  $form = $(form)
  $errmsg = $('p.error_msg', $form)
  error = (msg) ->
    $errmsg.text(msg).show()
    return false
  
  if not $form.find("input").val()
    return error '密码不能为空'
  else if $("input[name='reset_pwd']").val() != $("input[name='pwd_sure']").val()
    return error '两次输入的密码不一致'
  else if $("input[name='reset_pwd']").val().length < 6 or $("input[name='pwd_sure']").val().length < 6
       return error '密码不能少于6位'
  else if $("input[name='old_pwd']").val() == $("input[name='pwd_sure']").val()
    return error '原密码与新密码不能相同'

  options =
    dataType : 'json',
    success: (result) ->
      if result == '修改成功'
        showTipsbox '密码修改成功','access'
        $form.clearForm()
        $errmsg.hide()
      else
        error result
  $form.ajaxSubmit options
  return false

loadUserInfo = (callback) ->
  callback or= initUserInfo
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
    scrolling: false
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
        showTipsbox('删除成功','access','reload')
      else if type == 'user'
        if where  == 'user_center_followee'
          showTipsbox('删除成功','access','reload')
        else # detail, user center left
          showTipsbox('取消关注成功','access')
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
      else if type == 'user' # detail, user center left
        if data.status == 'success'
          $e.addClass('favorited')
  )
showMsgbox = (msg, toUrl) ->
  '
  toUrl - the url to go when box closes
    current - reload current page
    url - redirect to given url
    null - do nothing
  '
  $('#msgbox').show()
  $('#msgbox p').text(msg)
  $.colorbox
    overlayClose: true
    fixed: true
    opacity: 0.5
    inline: true
    href: '#msgbox'
    open: true
    width: 350
    height: 150
    initialWidth: 350
    initialHeight: 150
    scrolling: false
    onClosed: ->
      $('#msgbox').hide()
      if not toUrl then return
      if toUrl == 'current'
        window.location.reload()
      else
        window.location.href = toUrl

handleSigninOk = ($form) ->
  if $form.data('return') # single signin page
    window.location.href = $form.data('return')
  else if g1001.pageId.match /^sns-|^sign(in|up)$/ # redirect to home for sns login related page and single signin/signup page
    window.location.href = '/'
  else
    window.location.reload()
signin = (form) ->
  $form = $(form)
  error = (msg) ->
    $('.err_msg', $form).text(msg).show()
    return false
  messages =
    'AUTH_FAIL': '错误的用户名或密码'
  username = $('input.username', $form).val()
  if not username then return error('Email不能为空')

  options =
    dataType : 'json'
    success: (result) ->
      if result.status == 'OK'
        handleSigninOk($form)
      else
        error(messages[result.status] or result.status)
    error: -> error('未知错误')
  $form.ajaxSubmit options
  return false
signup = (form) ->
  $form = $(form)
  error = (msg) ->
    $('p.err_msg', $form).text(msg).show()
    return false
  email = $('input.username', $form).val()
  passwd = $('input.passwd', $form).val()
  re_passwd = $('input.re_passwd', $form).val()
  if passwd.length < 6
    return error('密码长度不能小于6位')
  if passwd.length > 16
    return error('密码长度不能大于16位')
  if not email
    return error('Email不能为空')
  if not checkEmail(email)
    return error('Email格式不正确')
  if not passwd
    return error '密码不能为空'
  if passwd != re_passwd
    return error('密码不一致')
  if not $('input.agreement').is(':checked')
    return error('您必须同意1001夜法律声明')

  messages =
    'USER_EXISTS': '此邮箱已经注册过，请更换其他邮箱'
  options =
    dataType : 'json'
    success: (result) ->
      if result.status == 'OK'
        handleSigninOk $form
      else
        error(messages[result.status] || result.status)

  $form.ajaxSubmit(options)
  return false
applyAuthor = (form) -> # 申请成为作者
  $form = $(form)
  if not $('input.code', $form).val()
    $('p.err_msg', $form).text('请输入邀请码')
    return false

  options =
    dataType : 'json',
    success: (result) ->
      if result.status == 'OK'
        $('#apply_author div.main').hide()
        $('#apply_author div.apply_ok').show()
        setTimeout  (-> $.colorbox.close()), 3000
      else
        $(".err_msg").html(result.message)

  $form.ajaxSubmit(options)
  return false

magSns = {
  init:($links)->
    if typeof $links is 'undefined' then return
    $links.each(->
      this.onclick=->
        window.open(this.href,"_blank","width=615,height=505,left=#{$(window).width()/4}px")
        return false
    )
}
$ -> magSns.init($("a.header-snslogin"))

showTipsbox = (msg, type, reload) ->
 html = "<p id='global-tips-"+type+"'>"+msg+"</p>"
 $(document.body).append(html)
 $("#global-tips-"+type).hide()
 $("#global-tips-"+type).fadeIn()
 if typeof reload != 'undefined'
   setTimeout((->window.location.reload()),2000)
 setTimeout((->$("#global-tips-"+type).fadeOut()),2000)
 setTimeout((->$("#global-tips-"+type).remove()),2500)
