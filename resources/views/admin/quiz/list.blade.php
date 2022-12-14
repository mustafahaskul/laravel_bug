<x-app-layout>
    <x-slot name="header">Quizler</x-slot>

    <div class="card">
        <div class="card-body">
            <h5 style="float: right;" class="card-title">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <a href="{{route('quizzes.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Quiz Oluştur</a>
            </h5>
            <form method="GET" action="">
                <div class="form-row ">
                    <div class="col-md-2 d-inline-block ">
                        <input type="text" name="title" value="{{request()->get('title')}}" placeholder="Quiz Adı" class="form-control">
                    </div>
                    <div class="col-md-2 d-inline-block">
                        <select class="form-control" onchange="this.form.submit()" name="status">
                            <option value="">Durum Seçiniz</option>
                            <option @if(request()->get('status')=='publish') selected @endif value="publish">Aktif</option>
                            <option @if(request()->get('status')=='passive') selected @endif value="passive">Pasif</option>
                            <option @if(request()->get('status')=='draft') selected @endif value="draft">Taslak</option>
                        </select>
                    </div>
                    @if(request()->get('title') || request()->get('status'))
                    <div class="col-md-2 d-inline-block">
                        <a href="{{route('quizzes.index')}}" class="btn btn-secondary btn-md">Sıfırla</a>
                    </div>
                    @endif
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Quiz</th>
                        <th scope="col">Soru Sayısı</th>
                        <th scope="col">Durum</th>
                        <th scope="col">Bitiş Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizzes as $quiz) { ?>
                        <tr>
                            <td>{{$quiz->title}}</td>
                            <td>{{$quiz->questions_count}}</td>
                            <td>
                                @switch($quiz->status)
                                @case('publish')

                                @if(!$quiz->finished_at)
                                    <span style="color: black;" class="badge bg-success">Aktif</span>
                                @elseif($quiz->finished_at > now())
                                    <span style="color: black;" class="badge bg-success">Aktif</span>
                                @else
                                <span style="color: black;" class="badge bg-secondary text-white">Süresi Doldu</span>
                                @endif
                                @break
                                @case('passive')
                                <span style="color: black;" class="badge bg-danger">Pasif</span>
                                @break
                                @case('draft')
                                <span style="color: black;" class="badge bg-warning">Taslak</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                <span title="{{$quiz->finished_at}}">
                                    {{$quiz->finished_at ? $quiz->finished_at->diffForHumans() : '-'}}
                                </span>
                            </td>
                            <td>
                                <a href="{{route('quizzes.details',$quiz->id)}}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                <a href="{{route('questions.index',$quiz->id)}}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-question"></i>
                                </a>
                                <a href="{{route('quizzes.edit',$quiz->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                <a href="{{route('quizzes.destroy',$quiz->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            {{$quizzes->withQueryString()->links()}}
        </div>
    </div>
</x-app-layout>