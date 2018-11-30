CSSPATH = assets/css
JSPATH = assets/js

.PHONY: clean css.min.css js.min.js

.PHONY: css.min.css
css.min.css: $(CSSPATH)/*.css
	cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(CSSPATH)/$@

.PHONY: js.min.js
js.min.js: $(JSPATH)/*.css
	cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(JSPATH)/$@

.PHONY: clean
clean:
	rm -rf $(CSSPATH)/*.min.css $(JSPATH)/*.min.js
