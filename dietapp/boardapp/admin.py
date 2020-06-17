from django.contrib import admin
from .models import BoardModel
# Register your models here.
#ここでアプリのモデルを読み込ませる
admin.site.register(BoardModel)