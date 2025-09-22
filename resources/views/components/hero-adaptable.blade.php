{{-- resources/views/components/hero-adaptable.blade.php --}}

@once
    {{-- ESTILOS --}}
    <style>
      .hero { position: relative; }
      .hero > img#hero-bg { width: 100%; height: auto; display: block; }

      .hero .overlay{
        position: absolute; inset: 0;
        background: rgba(0,0,0,.32);
        transition: background-color .25s ease;
        pointer-events: none;
      }

      .hero .hero-content { position: absolute; inset: 0; display:flex; align-items:center; justify-content:center; flex-direction:column; }
      .hero .hero-heading { font-weight: 700; margin-bottom: 1rem; transition: color .25s ease, text-shadow .25s ease; }
      .hero .hero-sub { margin-bottom: 1.25rem; transition: color .25s ease, text-shadow .25s ease; }

      .hero.dark .hero-heading,
      .hero.dark .hero-sub { color: #fff; text-shadow: 0 2px 14px rgba(0,0,0,.45); }
      .hero.dark .overlay { background: rgba(0,0,0,.28); }

      .hero.light .hero-heading,
      .hero.light .hero-sub { color: #111; text-shadow: 0 1px 8px rgba(255,255,255,.45); }
      .hero.light .overlay { background: rgba(0,0,0,.45); }
    </style>

    {{-- SCRIPT --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const img = document.getElementById('hero-bg');
        const hero = document.querySelector('.hero');
        if (!img || !hero) return;

        const analyze = () => {
          try {
            const canvas = document.createElement('canvas');
            const s = 50;
            canvas.width = s; canvas.height = s;
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            ctx.drawImage(img, 0, 0, s, s);
            const { data } = ctx.getImageData(0, 0, s, s);

            let r = 0, g = 0, b = 0, count = s * s;
            for (let i = 0; i < data.length; i += 4) {
              r += data[i]; g += data[i + 1]; b += data[i + 2];
            }
            r /= count; g /= count; b /= count;

            const Y = 0.2126 * r + 0.7152 * g + 0.0722 * b;
            hero.classList.toggle('dark', Y < 140);
            hero.classList.toggle('light', Y >= 140);
          } catch (e) {
            hero.classList.add('light');
          }
        };

        if (img.complete) analyze();
        else img.addEventListener('load', analyze);
      });
    </script>
@endonce
