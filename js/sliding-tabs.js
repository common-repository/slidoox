//Big Thanks to creativepony for this script
//Documentation: http://creativepony.com/journal/scripts/sliding-tabs/


var SlidingTabs = new Class({
  options: { startingSlide: false, activeButtonClass: 'active',
  
  	/*CHOOSE BETWEEN MOUSEOVER OR CLICK FOR START*/
  	activationEvent: 'click', 
    //activationEvent: 'mouseover', 
    wrap: true, 
    slideEffect: { 
	   
	   
	    	/*CHOOSE BETWEEN YOU EFFECT START*/ 
       transition: Fx.Transitions.Bounce.easeOut,//BOUNCE EFFECT
	   //transition: Fx.Transitions.Cubic.easeOut,//CUBIC EFFECT
       //transition: Fx.Transitions.Quart.easeOut,//QUART EFFECT
       //transition: Fx.Transitions.Circ.easeOut,//CIRC EFFECT



	  duration: 800 // 0.8 of a second
    },
    animateHeight: false,rightOversized: 0 
  },
  current: null,   buttons: false,  outerSlidesBox: null,  innerSlidesBox: null,  panes: null,  fx: null,   heightFx: null, 
  
  
  initialize: function(buttonContainer, slideContainer, options) {
    if (buttonContainer) { this.buttons = $(buttonContainer).getChildren(); }
    this.outerSlidesBox = $(slideContainer);
    this.innerSlidesBox = this.outerSlidesBox.getFirst();
    this.panes = this.innerSlidesBox.getChildren();
    
    this.setOptions(options);
    
    this.fx = new Fx.Scroll(this.outerSlidesBox, this.options.slideEffect);
    this.heightFx = this.outerSlidesBox.effect('height', this.options.slideEffect);
    
   
    this.current = this.options.startingSlide ? this.panes.indexOf($(this.options.startingSlide)) : 0;
    if (this.buttons) { this.buttons[this.current].addClass(this.options.activeButtonClass); }
    
   
    this.outerSlidesBox.setStyle('overflow', 'hidden');
    this.panes.each(function(pane, index) {
      pane.setStyles({
       'float': 'left',
       'overflow': 'hidden'
      });
    }.bind(this));
    
    this.innerSlidesBox.setStyle('float', 'left');
    
    if (this.options.startingSlide) this.fx.toElement(this.options.startingSlide);
    
   
    if (this.buttons) this.buttons.each( function(button) {
      button.addEvent(this.options.activationEvent, this.buttonEventHandler.bindWithEvent(this, button));
    }.bind(this));
    
    if (this.options.animateHeight)
      this.heightFx.set(this.panes[this.current].offsetHeight);
    
    
   
    this.recalcWidths();
  },
  
  
  changeTo: function(element, animate) {
    if ($type(element) == 'number') element = this.panes[element - 1];
    if (!$defined(animate)) animate = true;
    var event = { cancel: false, target: $(element), animateChange: animate };
    this.fireEvent('change', event);
    if (event.cancel == true) { return; };
    
    if (this.buttons) { this.buttons[this.current].removeClass(this.options.activeButtonClass); };
    this.current = this.panes.indexOf($(event.target));
    if (this.buttons) { this.buttons[this.current].addClass(this.options.activeButtonClass); };
    
    this.fx.stop();
    if (event.animateChange) {
      this.fx.toElement(event.target);
    } else {
      this.outerSlidesBox.scrollTo(this.current * this.outerSlidesBox.offsetWidth.toInt(), 0);
    }
    
    if (this.options.animateHeight)
      this.heightFx.start(this.panes[this.current].offsetHeight);
  },
  
  
  buttonEventHandler: function(event, button) {
    if (event.target == this.buttons[this.current]) return;
    this.changeTo(this.panes[this.buttons.indexOf($(button))]);
  },
  

  

  recalcWidths: function() {
    this.panes.each(function(pane, index) {
      pane.setStyle('width', this.outerSlidesBox.offsetWidth.toInt() - this.options.rightOversized + 'px');
    }.bind(this));
    
    this.innerSlidesBox.setStyle(
      'width', (this.outerSlidesBox.offsetWidth.toInt() * this.panes.length) + 'px'
    );
    

    if (this.current > 0) {
      this.fx.stop();
      this.outerSlidesBox.scrollTo(this.current * this.outerSlidesBox.offsetWidth.toInt(), 0);
    }
  }
});

SlidingTabs.implement(new Options, new Events);
