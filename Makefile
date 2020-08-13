CSSPATH = assets/css
JSPATH = assets/js

FILE = ./source/${file}

index:
	@echo "usage: "
	@echo "make add file=FILENAME.md"
	@echo "make generate"

generate: clean js css
	@php ./bin/generate

css: $(CSSPATH)/*.css
	# cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(CSSPATH)/"css.min.css"
	cat $^ > $(CSSPATH)/"css.min.css"

js: $(JSPATH)/*.js
	# cat $^ | sed "s@/\*.*\*/@@g" | sed '/\/\*/,/\*\//d' | sed ':a;N;s/\n//;ba;' > $(JSPATH)/"js.min.js"
	cat $^ > $(JSPATH)/"js.min.js"

clean:
	rm -rf $(CSSPATH)/*.min.css $(JSPATH)/*.min.js

add:
# 判断文件是否存在
ifeq (, $(wildcard $(FILE)))
	touch $(FILE)
	@echo "---\ndate: $(shell date +"%F")\ntitle: ${file}\n---" > $(FILE)
else
	@echo "File already exists"
endif

.PHONY: clean js css index generate add
