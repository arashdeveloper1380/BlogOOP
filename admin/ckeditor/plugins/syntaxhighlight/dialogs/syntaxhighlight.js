CKEDITOR.dialog.add( 'syntaxhighlightDialog', function( editor ) {
	var getDefaultOptions=function() {
		var options=new Object();
		var validLangs=['actionscript3','as3','cpp','c','c#','c-sharp','csharp','css','delphi','pascal','pas','js','jscript','javascript','php','text','plain','powershell','ps','posh','py','python','sql','vb','vbnet','xml','xhtml','xslt','html'];
		options.hideGutter=String(editor.config.syntaxhighlight_hideGutter).toLowerCase()==='true';
		options.hideControls=String(editor.config.syntaxhighlight_hideControls).toLowerCase()==='true';
		options.collapse=String(editor.config.syntaxhighlight_collapse).toLowerCase()==='true';
		options.codeTitle=editor.config.syntaxhighlight_codeTitle;
		options.showColumns=String(editor.config.syntaxhighlight_showColumns).toLowerCase()==='true';
		options.noWrap=String(editor.config.syntaxhighlight_noWrap).toLowerCase()==='true';
		options.firstLine=editor.config.syntaxhighlight_firstLine;
		options.highlightChecked=String(editor.config.syntaxhighlight_highlightChecked).toLowerCase()==='true';
		options.highlight=editor.config.syntaxhighlight_highlight;
		options.lang=(validLangs.indexOf(editor.config.syntaxhighlight_lang)>-1) ? editor.config.syntaxhighlight_lang : 'as3';
		options.code=editor.config.syntaxhighlight_code;
		return options
	};
	var getOptionsForString=function(preElement) {
		var options=getDefaultOptions();
		var optionsString=preElement.getAttribute('class');
		if(optionsString) {
			if(optionsString.indexOf('brush')>-1) {
				var match=/brush:[ ]*(\w*)/.exec(optionsString);
				if(match!=null&&match.length>0) {
					options.lang=match[1].replace(/^\s+|\s+$/g,'');
					if(options.lang=='actionscript') options.lang='as3';
					else if(options.lang=='c') options.lang='cpp';
					else if(options.lang=='c#'||options.lang=='c-sharp') options.lang='csharp';
					else if(options.lang=='pascal'||options.lang=='pas') options.lang='delphi';
					else if(options.lang=='js'||options.lang=='javascript') options.lang='jscript';
					else if(options.lang=='text') options.lang='plain';
					else if(options.lang=='powershell'||options.lang=='posh') options.lang='ps';
					else if(options.lang=='py') options.lang='python';
					else if(options.lang=='vbnet') options.lang='vb';
					else if(options.lang=='xhtml'||options.lang=='xslt'||options.lang=='html') options.lang='xml'
				}
			}
			if(optionsString.indexOf('gutter')>-1) {
				options.hideGutter=true
			}
			if(optionsString.indexOf('toolbar')>-1) {
				options.hideControls=true
			}
			if(optionsString.indexOf('collapse')>-1) {
				options.collapse=true
			}
			if(optionsString.indexOf('first-line')>-1) {
				var match=/first-line:[ ]*([0-9]{1,4})/.exec(optionsString);
				if(match!=null&&match.length>0&&match[1]>1) {
					options.firstLine=match[1]
				}
			}
			if(optionsString.indexOf('highlight')>-1) {
				if(optionsString.match(/highlight:[ ]*\[[0-9]+(,[0-9]+)*\]/)) {
					var match_hl=/highlight:[ ]*\[(.*)\]/.exec(optionsString);
					if(match_hl!=null&&match_hl.length>0) {
						options.highlightChecked=true;
						options.highlight=match_hl[1]
					}
				}
			}
			if(optionsString.indexOf('ruler')>-1) {
				options.showColumns=true
			}
			if(optionsString.indexOf('wrap-lines')>-1) {
				options.noWrap=true
			}
			var codeTitle=preElement.getAttribute('title');
			if (codeTitle) {
				codeTitle=codeTitle.replace(/^\s+|\s+$/g,'');
				if(codeTitle.length>0) {
					options.codeTitle=codeTitle
				}
			}
		}
		return options
	};
	var getStringForOptions=function(optionsObject) {
		var result='brush:'+optionsObject.lang+';';
		if(optionsObject.hideGutter) {
			result+='gutter:false;'
		}
		if(optionsObject.hideControls) {
			result+='toolbar:false;'
		}
		if(optionsObject.collapse) {
			result+='collapse:true;'
		}
		if(optionsObject.showColumns) {
			result+='ruler:true;'
		}
		if(optionsObject.noWrap) {
			result+='wrap-lines:false;'
		}
		if(optionsObject.firstLine.length>0) {
			optionsObject.firstLine=optionsObject.firstLine.replace(/[^0-9]+/g,'');
			if(optionsObject.firstLine.length>0&&optionsObject.firstLine>1) {
				result+='first-line:'+optionsObject.firstLine+';'
			}
		}
		if(optionsObject.highlight!=null&&optionsObject.highlight.length>0) {
			optionsObject.highlight=optionsObject.highlight.replace(/[^\d,]+/g,'').replace(/,{2,}/g,',').replace(/(^,)|(,$)/g,'');
			if(optionsObject.highlight.length>0) {
				result+='highlight:['+optionsObject.highlight.replace(/\s/gi,'')+'];'
			}
		}
		return result
	};
	var getTitleForOptions=function(optionsObject){
		optionsObject.codeTitle=optionsObject.codeTitle.replace(/^\s+|\s+$/g,'');
		if(optionsObject.codeTitle.length>0) {
			 return optionsObject.codeTitle
		}
		return false
   	};
	return {
		title : editor.lang.syntaxhighlight.title,
		minWidth : 500,
		minHeight : 400,
		contents : [
			{
				id : 'source',
				label : editor.lang.syntaxhighlight.sourceTab,
				accessKey : 'S',
				elements : [
					{
						type : 'vbox',
						children : [
							{
								id : 'cmbLang',
								type : 'select',
								labelLayout : 'horizontal',
								label : editor.lang.syntaxhighlight.langLbl,
								widths : ['25%','75%'],
								items : [
									['ActionScript3','as3'],
									['C#','csharp'],
									['C++','cpp'],
									['CSS','css'],
									['Delphi','delphi'],
									['Javascript','jscript'],
									['PHP','php'],
									['Plain (Text)','plain'],
									['PowerShell','ps'],
									['Python','python'],
									['SQL','sql'],
									['VB','vb'],
									['XML/XHTML/HTML','xml']
								],
								setup : function(data) {
									if(data.lang) {
										this.setValue(data.lang)
									}
								},
								commit : function(data) {
									data.lang=this.getValue()
								}
							}
						]
					},
					{
						type : 'textarea',
						id : 'hl_code',
						rows : 25,
						style : 'width:100%',
						validate: CKEDITOR.dialog.validate.notEmpty( editor.lang.syntaxhighlight.sourceTextareaEmptyError ),
						setup : function(data) {
							if(data.code) {
								this.setValue(data.code)
							}
						},
						commit : function(data) {
							data.code=this.getValue()
						}
					}
				]
			},
			{
				id : 'advanced',
				label : editor.lang.syntaxhighlight.advancedTab,
				accessKey : 'A',
				elements : [
					{
						type : 'vbox',
						children : [
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.hideGutter+'</strong>'
							},
							{
								type : 'checkbox',
								id : 'hide_gutter',
								label : editor.lang.syntaxhighlight.hideGutterLbl,
								setup : function(data) {
									this.setValue(data.hideGutter)
								},
								commit : function(data) {
									data.hideGutter=this.getValue()
								}
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.hideControls+'</strong>'
							},
							{
								type : 'checkbox',
								id : 'hide_controls',
								label : editor.lang.syntaxhighlight.hideControlsLbl,
								setup : function(data) {
									this.setValue(data.hideControls)
								},
								commit : function(data) {
									data.hideControls=this.getValue()
								}
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.collapse+'</strong>'
							},
							{
								type : 'checkbox',
								id : 'collapse',
								label : editor.lang.syntaxhighlight.collapseLbl,
								setup : function(data) {
									this.setValue(data.collapse)
								},
								commit : function(data) {
									data.collapse=this.getValue()
								}
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.codeTitleLbl+'</strong>'
							},
							{
								type : 'hbox',
								widths : ['5%','95%'],
								children : [
									{
										type : 'text',
										id : 'default_ti',
										style : 'width:40%',
										label : '',
										setup : function(data) {
											if(data.codeTitle!=null) {
												this.setValue(data.codeTitle)
											}
										},
										commit : function(data) {
											if(this.getValue()&&this.getValue()!='') {
												data.codeTitle=this.getValue()
											}
										}
									}
								]
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.showColumns+'</strong>'
							},
							{
								type : 'checkbox',
								id : 'show_columns',
								label : editor.lang.syntaxhighlight.showColumnsLbl,
								setup : function(data) {
									this.setValue(data.showColumns)
								},
								commit : function(data) {
									data.showColumns=this.getValue()
								}
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.lineWrap+'</strong>'
							},
							{
								type : 'checkbox',
								id : 'line_wrap',
								label : editor.lang.syntaxhighlight.lineWrapLbl,
								setup : function(data) {
									this.setValue(data.noWrap)
								},
								commit : function(data) {
									data.noWrap=this.getValue()
								}
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.lineCount+'</strong>'
							},
							{
								type : 'hbox',
								widths : ['5%','95%'],
								children : [
									{
										type : 'text',
										id : 'default_lc',
										style : 'width:15%',
										label : '',
										setup : function(data) {
											if(data.firstLine>1) {
												this.setValue(data.firstLine)
											}
										},
										commit : function(data) {
											if(this.getValue()&&this.getValue()!='') {
												data.firstLine=this.getValue()
											}
										}
									}
								]
							},
							{
								type : 'html',
								html : '<strong>'+editor.lang.syntaxhighlight.highlight+'</strong>'
							},
							{
								type : 'hbox',
								widths : ['5%','95%'],
								children : [
									{
										type : 'text',
										id : 'default_hl',
										style : 'width:40%',
										label : '',
										setup : function(data) {
											if(data.highlight!=null) {
												this.setValue(data.highlight)
											}
										},
										commit : function(data) {
											if(this.getValue()&&this.getValue()!='') {
												data.highlight=this.getValue()
											}
										}
									}
								]
							},
							{
								type : 'hbox',
								widths : ['5%','95%'],
								children : [
									{
										type : 'html',
										html : '<i>'+editor.lang.syntaxhighlight.highlightLbl+'</i>'
									}
								]
							}
						]
					}
				]
			}
		],
		onShow : function() {
			var editor=this.getParentEditor();
			var selection=editor.getSelection();
			var element=selection.getStartElement();
			var preElement=element&&element.getAscendant('pre',true);
			var text='';
			var optionsObj=null;
			if(preElement) {
				code=preElement.getHtml().replace(/<br>/g,"\n").replace(/&nbsp;/g,' ').replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&quot;/g,'"').replace(/&amp;/g,'&');
				optionsObj=getOptionsForString(preElement);
				optionsObj.code=code
			} else {
				optionsObj=getDefaultOptions()
			}
			this.setupContent(optionsObj)
		},
		onOk : function() {
			var editor=this.getParentEditor();
			var selection=editor.getSelection();
			var element=selection.getStartElement();
			var preElement=element&&element.getAscendant('pre',true);
			var data=getDefaultOptions();
			this.commitContent(data);
			var optionsString=getStringForOptions(data);
			var ti=getTitleForOptions(data);
			if(preElement) {
				preElement.setAttribute('class', optionsString);
				(ti!=false) ? preElement.setAttribute('title', ti) : preElement.removeAttribute('title');
				preElement.setText(data.code)
			} else {
				var newElement=new CKEDITOR.dom.element('pre');
				newElement.setAttribute('class', optionsString);
				if (ti!=false) newElement.setAttribute('title', ti);
				newElement.setText(data.code);
				editor.insertElement(newElement)
			}
		}
	}
})
