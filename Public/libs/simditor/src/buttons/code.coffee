
class CodeButton extends Button

  name: 'code'

  icon: 'code'

  htmlTag: 'pre'

  disableTag: 'ul, ol, table'

  _init: ->
    super()

    @editor.on 'decorate', (e, $el) =>
      $el.find('pre').each (i, pre) =>
        @decorate $(pre)

    @editor.on 'undecorate', (e, $el) =>
      $el.find('pre').each (i, pre) =>
        @undecorate $(pre)

  render: (args...) ->
    super args...
    @popover = new CodePopover
      button: @

  _status: ->
    super()

    if @active
      @popover.show(@node)
    else
      @popover.hide()

  decorate: ($pre) ->
    $code = $pre.find('> code')
    if $code.length > 0
      lang = $code.attr('class')?.match(/lang-(\S+)/)?[1]
      $code.contents().unwrap()
      $pre.attr('data-lang', lang) if lang

  undecorate: ($pre) ->
    lang = $pre.attr('data-lang')
    $code = $('<code/>')
    $code.addClass('lang-' + lang) if lang and lang != -1
    $pre.wrapInner($code)
      .removeAttr('data-lang')

  command: ->
    $rootNodes = @editor.selection.rootNodes()
    nodeCache = []
    pres = []

    clearCache = =>
      return unless nodeCache.length > 0
      $pre = $("<#{@htmlTag}/>")
        .insertBefore(nodeCache[0])
        .text(@editor.formatter.clearHtml(nodeCache))
      pres.push $pre[0]
      nodeCache.length = 0

    $rootNodes.each (i, node) =>
      $node = $ node
      if $node.is @htmlTag
        clearCache()
        $('<p/>').append($node.html().replace('\n', '<br/>'))
          .replaceAll($node)
      else if $node.is(@disableTag) or @editor.util.isDecoratedNode($node) or
          $node.is('blockquote')
        clearCache()
      else
        nodeCache.push node

    clearCache()

    @editor.selection.setRangeAtEndOf $(pres).last()
    @editor.trigger 'valuechanged'


class CodePopover extends Popover

  render: ->
    @_tpl = """
      <div class="code-settings">
        <div class="settings-field">
          <select class="select-lang">
            <option value="-1">#{@_t 'selectLanguage'}</option>
          </select>
        </div>
      </div>
    """

    @langs = @editor.opts.codeLanguages || [
      { name: 'Bash', value: 'bash' }
      { name: 'C++', value: 'c++' }
      { name: 'C#', value: 'cs' }
      { name: 'CSS', value: 'css' }
      { name: 'Erlang', value: 'erlang' }
      { name: 'Less', value: 'less' }
      { name: 'Sass', value: 'sass' }
      { name: 'Diff', value: 'diff' }
      { name: 'CoffeeScript', value: 'coffeescript' }
      { name: 'HTML,XML', value: 'html' }
      { name: 'JSON', value: 'json' }
      { name: 'Java', value: 'java' }
      { name: 'JavaScript', value: 'js' }
      { name: 'Markdown', value: 'markdown' }
      { name: 'Objective C', value: 'oc' }
      { name: 'PHP', value: 'php' }
      { name: 'Perl', value: 'parl' }
      { name: 'Python', value: 'python' }
      { name: 'Ruby', value: 'ruby' }
      { name: 'SQL', value: 'sql'}
    ]

    @el.addClass('code-popover')
      .append(@_tpl)
    @selectEl = @el.find '.select-lang'

    for lang in @langs
      $option = $ '<option/>',
        text: lang.name
        value: lang.value
      .appendTo @selectEl

    @selectEl.on 'change', (e) =>
      @lang = @selectEl.val()
      selected = @target.hasClass('selected')
      @target.removeClass()
        .removeAttr('data-lang')

      if @lang isnt -1
        @target.attr('data-lang', @lang)

      @target.addClass('selected') if selected
      @editor.trigger 'valuechanged'

    @editor.on 'valuechanged', (e) =>
      @refresh() if @active

  show: (args...) ->
    super args...
    @lang = @target.attr('data-lang')
    if @lang? then @selectEl.val(@lang) else @selectEl.val(-1)


Simditor.Toolbar.addButton CodeButton
