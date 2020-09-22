if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
	RedactorPlugins.fontcolor = function()
	{
		return {
			init: function()
			{
				var colors = [

'#619EFF', '#000000', '#FF9900', '#669900', '#006600', '#000099', '#330066', '#990066', '#660000', '#663300', '#333333', '#003399', '#0000FF', '#FF9966', '#CCFF00', '#009900', '#0000CC', '#6600CC', '#CC0099', '#990000', '#996600', '#666666', '#CC0000', '#FF0000', '#FFCC00', '#CCFF99', '#00CC00', '#0066FF', '#9900FF', '#CC00FF', '#FF6699', '#CC6600', '#AAAAAA', '#FFCC33', '#FFFF00', '#FFFF66', '#FFFF99', '#99FF99', '#99CCFF', '#CC99FF', '#FF00FF', '#FF99CC', '#FF9999', '#DDDDDD', '#009966', '#00FF00', '#FFFFCC', '#FFFFFF', '#CCFFCC', '#CCFFFF', '#CCCCFF', '#FFCCFF', '#FFCCCC', '#FFCC99', '#EEEEEE'

				];

				var buttons = ['fontcolor', 'backcolor'];

				for (var i = 0; i < 2; i++)
				{
					var name = buttons[i];

					var button = this.button.add(name, this.lang.get(name));
					var $dropdown = this.button.addDropdown(button);

					$dropdown.width(242);
					this.fontcolor.buildPicker($dropdown, name, colors);

				}
			},
			buildPicker: function($dropdown, name, colors)
			{
				var rule = (name == 'backcolor') ? 'background-color' : 'color';

				var len = colors.length;
				var self = this;
				var func = function(e)
				{
					e.preventDefault();
					self.fontcolor.set($(this).data('rule'), $(this).attr('rel'));
				};

				for (var z = 0; z < len; z++)
				{
					var color = colors[z];

					var $swatch = $('<a rel="' + color + '" data-rule="' + rule +'" href="#" style="float: left; font-size: 0; border: 2px solid #fff; padding: 0; margin: 0; width: 22px; height: 22px;"></a>');
					$swatch.css('background-color', color);
					$swatch.on('click', func);

					$dropdown.append($swatch);
				}

				var $elNone = $('<a href="#" style="display: block; clear: both; padding: 5px; font-size: 12px; line-height: 1;"></a>').html(this.lang.get('none'));
				$elNone.on('click', $.proxy(function(e)
				{
					e.preventDefault();
					this.fontcolor.remove(rule);

				}, this));

				$dropdown.append($elNone);
			},
			set: function(rule, type)
			{
				this.inline.format('span', 'style', rule + ': ' + type + ';');
			},
			remove: function(rule)
			{
				this.inline.removeStyleRule(rule);
			}
		};
	};
})(jQuery);