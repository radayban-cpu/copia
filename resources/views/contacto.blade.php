@extends('layouts.app')

@section('title', 'Contacto - Curriculum')
@section('body-class', 'contact-page')

@section('content')
<main class="main">
  <section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Contacto</h2>
      <p>Podés escribirme directamente con el siguiente formulario o por los medios de contacto.</p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-4">
          @if($dato)
          <div class="info-wrap">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div><h3>Dirección</h3><p>{{ $dato->ciudad_domicilio }}</p></div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div><h3>Teléfono</h3><p>{{ $dato->telefono }}</p></div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div><h3>Email</h3><p>{{ $dato->email }}</p></div>
            </div>
            
            {{-- URL DEL MAPA CORREGIDA --}}
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d44486.64404144853!2d-57.48355344235229!3d-25.346085652956543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spy!4v1757879074328!5m2!1ses-419!2spy" width="350" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

          </div>
          @endif
        </div>
        <div class="col-lg-8">
          <form action="{{ route('contacto.enviar') }}" method="post" data-aos="fade-up" data-aos-delay="200">
            @csrf
            
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    Por favor, corrige los errores y vuelve a intentarlo.
                </div>
            @endif

            <div class="row gy-4">
              <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="Tu Nombre" required></div>
              <div class="col-md-6 "><input type="email" class="form-control" name="email" placeholder="Tu Email" required></div>
              <div class="col-md-12"><input type="text" class="form-control" name="subject" placeholder="Asunto" required></div>
              <div class="col-md-12"><textarea class="form-control" name="message" rows="6" placeholder="Mensaje" required></textarea></div>
              <div class="col-md-12 text-center">
                <button type="submit">Enviar Mensaje</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection