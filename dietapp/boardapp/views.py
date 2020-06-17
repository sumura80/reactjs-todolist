from django.shortcuts import render
from .models import BoardModel
from django.shortcuts import redirect
from django.views.generic import CreateView
from django.urls import reverse_lazy

# Create your views here.
def listfunction(request):
  object_list = BoardModel.objects.all()

  return render(request, 'list.html',{'object_list':object_list})

def showfunction(request, pk):
  object_id = BoardModel.objects.get(pk=pk)
  return render(request,'show.html',{'object_id':object_id})


def likefunction(request,pk):
  article = BoardModel.objects.get(pk=pk)
  article.like = article.like + 1
  article.save()
  return redirect('list')


class PostCreate(CreateView):
  template_name='create.html'
  model = BoardModel
  fields = ('title', 'content', 'images')
  success_url = reverse_lazy('list')

