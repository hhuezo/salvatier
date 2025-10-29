<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {

        $abogados = [
            [
                'id' => 1,
                'nombre' => 'Lic. Moisés Guzman',
                'especialidad' => 'Especialista en Derecho Penal y Corporativo',
                'imagen' => 'images/lic1.webp',
            ],
            [
                'id' => 2,
                'nombre' => 'Lic. Juan Carlos Ríos',
                'especialidad' => 'Especialista en Derecho notarial, Penal, civil y Corporativo',
                'imagen' => 'images/lic2.webp',
            ],
            [
                'id' => 3,
                'nombre' => 'Lic. Samuel Contreras',
                'especialidad' => 'Especialista en Derecho Penal y Procesos Ejecutivos',
                'imagen' => 'images/lic3.webp',
            ],
            [
                'id' => 4,
                'nombre' => 'Lic. Francisco Maravilla',
                'especialidad' => 'Especialista en Derecho Penal, Derecho de familia y Laboral',
                'imagen' => 'images/lic4.webp',
            ],
            [
                'id' => 5,
                'nombre' => 'Licda. Karina de Melara',
                'especialidad' => 'Especialista en Derecho Penal, Derecho de familia',
                'imagen' => 'images/lic5.webp',
            ],
            [
                'id' => 6,
                'nombre' => 'Licda. Sindi Canales',
                'especialidad' => 'Especialista en Derecho Penal',
                'imagen' => 'images/lic6.webp',
            ],
            [
                'id' => 7,
                'nombre' => 'Licda. Wendi Galicia',
                'especialidad' => 'Especialista en Derecho Penal',
                'imagen' => 'images/lic7.webp',
            ],
            [
                'id' => 8,
                'nombre' => 'Licda. Josselyn Ríos',
                'especialidad' => 'Especialista en Derecho Penal',
                'imagen' => 'images/lic8.webp',
            ],
        ];


        $servicios = [
            [
                'id' => 1,
                'titulo' => 'Asesoría Legal Preventiva',
                'descripcion' => '<p>Ofrecen orientación para evitar incurrir en delitos o para manejar situaciones que podrían derivar en problemas legales. Esto puede incluir la revisión de contratos, políticas internas de empresas, o simplemente resolver dudas sobre la legalidad de ciertas acciones.</p>',
            ],
            [
                'id' => 2,
                'titulo' => 'Asistencia y Representación en Fase de Investigación',
                'descripcion' => 'Este es uno de los servicios más críticos: <ul><li>Asesorar al investigado desde el momento en que es notificado de una investigación.</li><li>Acompañar al investigado durante interrogatorios policiales o judiciales para asegurar que sus derechos sean respetados.</li><li>Realizar gestiones para la obtención de pruebas que favorezcan a su cliente.</li><li>Presentar recursos para impugnar detenciones o medidas cautelares.</li></ul>',
            ],
            [
                'id' => 3,
                'titulo' => 'Defensa en Juicios Penales',
                'descripcion' => '<p>Una vez que se formaliza una acusación, el despacho se encarga de la defensa del acusado, lo que incluye: </p><ul><li>Elaboración de la estrategia de defensa más adecuada para el caso.</li><li>Presentación de pruebas y contrainterrogatorio de testigos.</li><li>Argumentación legal ante el tribunal.</li><li>Representación en todas las fases del juicio, incluyendo audiencias preliminares y el juicio.</li></ul>',
            ],
            [
                'id' => 4,
                'titulo' => 'Acusación Particular',
                'descripcion' => '<p>En casos donde un cliente ha sido víctima de un delito, el despacho puede representarlo para:</p><ul><li>Presentar la denuncia o querella correspondiente.</li><li>Apersonarse en el proceso penal como acusación particular para buscar la condena del responsable y la reparación del daño.</li><li>Colectar pruebas que apoyen la acusación.</li></ul>',
            ],
            [
                'id' => 5,
                'titulo' => 'Recursos y Apelaciones',
                'descripcion' => '<p>Si la sentencia no es favorable, el despacho puede interponer los recursos legales pertinentes:</p><ul><li>Recurso de Apelación: Contra sentencias de primera instancia.</li><li>Recurso de Casación: En casos específicos ante tribunales superiores.</li><li>Recurso de Amparo: Para proteger derechos fundamentales vulnerados.</li><li>Recurso de Revocatoria: Con dicho recurso se busca que el juez revoque una decisión que ha tomado en audiencia que le cause agravio al representado.</li></ul>',
            ],
            [
                'id' => 6,
                'titulo' => 'Delitos Comunes',
                'descripcion' => '<ul><li>Delitos contra la vida y la integridad física (homicidio, lesiones).</li><li>Delitos contra la libertad y la seguridad (secuestro, amenazas).</li><li>Delitos contra el patrimonio (robo, hurto, estafa).</li><li>Delitos económicos y financieros (Lavado de dinero/blanqueo de capitales, fraude fiscal).</li><li>Delitos contra la libertad sexual.</li><li>Delitos de violencia de género o intrafamiliar.</li></ul>',
            ],
            [
                'id' => 7,
                'titulo' => 'Delitos Relacionados con Crimen organizado',
                'descripcion' => '<ul><li>Agrupaciones Ilícitas.</li><li>Trata de personas.</li><li>Delitos relacionados con el tráfico de drogas, entre otros.</li></ul>',
            ],
            [
                'id' => 8,
                'titulo' => 'Gestión de Medidas Cautelares y Ejecución de Sentencias',
                'descripcion' => '<ul><li>Audiencia Especial de Revisión de medidas cautelares.</li><li>Medios de impugnación (Recurso de revocatoria, revisión, apelación, casación entre otros).</li><li>Seguimiento de la fase de ejecución de la pena, incluyendo solicitudes de beneficios penitenciarios (media pena, libertad condicional, redención de penas).</li></ul>',
            ],
        ];


        $faqs = [
            [
                'id' => 1,
                'pregunta' => '¿Qué tipo de casos manejan?',
                'respuesta' => '<ul><li>Derecho penal: Delitos, Defensas, acusaciones.</li><li>Derecho civil: Contratos, Herencias, Propiedades, etc.</li><li>Derecho Mercantil Empresarial: Constitución de empresas, contratos comerciales, fusiones.</li><li>Derecho Familiar: Divorcios, custodia, pensiones alimenticias, entre otros.</li></ul>',
            ],
            [
                'id' => 2,
                'pregunta' => '¿Cuál es el precio de una Asesoría?',
                'respuesta' => 'El costo de una asesoría legal es de <b>$60.00.</b>',
            ],
            [
                'id' => 3,
                'pregunta' => '¿Necesito preparar algún documento o información antes de la primera asesoría?',
                'respuesta' => 'Si es necesario traer sus documentos de Identificación personal, números de documentos.',
            ],
            [
                'id' => 4,
                'pregunta' => '¿Cuánto tiempo dura el proceso?',
                'respuesta' => 'Depende del tipo de proceso y la materia de que se trate.',
            ],
            [
                'id' => 5,
                'pregunta' => '¿Cuál es el precio del proceso completo?',
                'respuesta' => 'Depende del caso y si es fuera o dentro de San Salvador.',
            ],
            [
                'id' => 6,
                'pregunta' => '¿Puedo cambiarle el apellido del padre a mi hijo?',
                'respuesta' => 'NO',
            ],
        ];



        $datos = [
            'nombreEmpresa' => 'SALVATIER ABOGADOS',
            'descripcion' => 'Más alla de nuestra experiencia técnica, nos distinguimos por nuestro enfoque empático y centrado en la persona. entendemos que cada caso es ńico y que detrás de cada situación legal hay un ser humano con necesidades y preocupaciones.',
            'equipoTitle' => 'Equipo jurídico',
            'equipoDesc' => 'Contamos con un equipo de abogados comprometidos con la justicia, la excelencia y las personas. Cada uno aporta su experiencia y conocimiento técnico, pero también un enfoque humano que entiende, acompaña y apoya a quienes confían en nosotros',
            'abogados' =>  $abogados,
            'serviciosJuridicos' =>  $servicios,
            'faqs' => $faqs,
            'mision' => 'Nuestra misión es brindar servicios legales de la más alta calidad con un enfoque profundamente humano, garantizando una defensa justa y accesible para todos. Nos dedicamos a comprender las necesidades individuales de cada cliente, ofreciendo soluciones jurídicas personalizadas que no solo aborden sus problemas legales, sino que también les brinden tranquilidad y apoyo en momentos difíciles. Actuamos con integridad, empatía y profesionalismo, buscando siempre la resolución más beneficiosa para nuestros representados, al tiempo que promovemos la justicia y el respeto por los derechos humanos en nuestra comunidad.',
            'vision' => 'Aspiramos a ser un despacho jurídico líder y referente en la región, reconocido por nuestra excelencia legal y, sobre todo, por nuestro compromiso inquebrantable con el bienestar de nuestros clientes. Buscamos trascender la relación abogado-cliente tradicional, construyendo lazos de confianza basados en la cercanía y la comprensión. Visualizamos un futuro donde el acceso a la justicia sea más equitativo y donde nuestro despacho sea un baluarte de la defensa de los derechos individuales y colectivos, contribuyendo activamente a una sociedad más justa y compasiva. Nos esforzamos por innovar en nuestras prácticas, manteniendo siempre un equilibrio entre la eficiencia legal y la calidez humana.',
            'gpsOficinaCentral' => 'https://maps.app.goo.gl/uuYb6wXdxp3a1rVP9',
            'facebookUrl' => 'https://www.facebook.com/salvatierley?mibextid=ZbWKwL',
            'instagramUrl' => 'https://www.instagram.com/salvatier_abogados?igsh=djFhOGc2MzgzMzVq',
            'youtubeUrl' => 'https://youtube.com/@culturalegalsv?si=1dWUvhfgvKL25AvC',
            'tikTokUrl' => 'https://www.tiktok.com/@salvatierabogados?_t=ZM-90xOusoVPTv&_r=1',
            'whatsappUrl' => 'https://wa.me/50373976850',
            'telefonoContacto' => '73976850',
            // Coordenadas GPS para el mapa de Google
            'mapLocations' => [
                [
                    'title' => 'Oficina Central',
                    'description' => 'Colonia médica, edificio inversiones médicas 250 B, segundo nivel, local 1.',
                    'lat' => 13.7088106,
                    'lng' => -89.2014538,
                ],
                [
                    'title' => 'SAN MIGUEL',
                    'description' => 'Acceso "A Contiguo a Medicina Legal" Plaza Sol, 7A Calle Poniente Local 6',
                    'lat' => 13.4761898,
                    'lng' => -88.181531,
                ],
                [
                    'title' => 'SANTA ANA',
                    'description' => 'A 4 cuadras de catedral la ex casa de la cultura de Santa Ana local 7, 2do nivel',
                    'lat' => 13.995581,
                    'lng' => -89.559813,
                ],
            ],
        ];

        return view('welcome', $datos);
    }
}
