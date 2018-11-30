CSSPATH = assets/css
JSPATH = assets/js

all: clean js css

css: $(CSSPATH)/*.css
	cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(CSSPATH)/"css.min.css"

js: $(JSPATH)/*.js
	cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(JSPATH)/"js.min.js"

clean:
	rm -rf $(CSSPATH)/*.min.css $(JSPATH)/*.min.js

.PHONY: clean js css
