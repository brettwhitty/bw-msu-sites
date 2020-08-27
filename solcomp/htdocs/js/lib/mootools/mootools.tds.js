var TextDropShadow = new Class({
        options: {
            color: '#333',
            left: 1,
            top: 1,
            position: 'absolute'
        },

        initialize: function(obj, options){
                this.setOptions(options)
                this.createDropShadows(obj);
        },
        
        createDropShadows: function(obj){
            if('element' == $type(obj)) {
                this.applyDropShadow(obj)
            } else if('array' == $type(obj)) {
                obj.each( function(el) {
                    this.applyDropShadow(el);
                }, this);
            } else {
                return false;
            }
        },
        
        applyDropShadow: function(el){
            var original = el.clone();
            var shadow = el.clone();

            var offsetY = this.options.top ? this.options.top.toInt() : this.options.bottom.toInt();
            if(offsetY < 0) offsetY = offsetY * (-1);
            
            var offsetX = this.options.left ? this.options.left.toInt() : this.options.right.toInt();
            if(offsetX < 0) offsetX = offsetX * (-1);
            
            var container = new Element('div', {
                    'styles': {
                            position: 'relative',
                            left: 0,
                            top: 0,
                            height: el.getSize().size.y + offsetY,
                            width: el.getSize().size.x + offsetX
                    }
            });

            original.setStyles({position: 'absolute', left: 0, top: 0});
            shadow.setStyles(this.options);
                        
            container.adopt(shadow).adopt(original);
            container.injectAfter(el);
            el.remove();
        }
});
TextDropShadow.implement(new Options, new Events);
