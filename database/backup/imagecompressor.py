#!/usr/bin/python 

foo = Image.open("./pic/image.jpg")

foo = foo.resize((160,300),Image.ANTIALIAS)
foo.save(/.image_scaled.jpg",quality=50)
foo.save("./image_scaled_opt.jpg",optimize=True,quality=95)