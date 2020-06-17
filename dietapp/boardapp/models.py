from django.db import models

# Create your models here.
#ダイエットアプリの内容に関するモデル
class BoardModel(models.Model):
  title = models.CharField(max_length=100)
  content = models.TextField()
  #ImageFieldを使う際には、pillowをインストールする
  images = models.ImageField(upload_to = '')
  like = models.IntegerField(null=True,blank=True ,default=0)
 