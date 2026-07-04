<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                <h1 class="text-2xl font-bold mb-4 text-utgz-primary">Aviso de Privacidad</h1>
                
                <p class="mb-4">
                    La Universidad Tecnológica de Gutiérrez Zamora (UTGZ), a través del Departamento de Residencias Profesionales,
                    es la responsable del tratamiento de los datos personales que nos proporcione, los cuales serán protegidos conforme 
                    a lo dispuesto por la Ley General de Protección de Datos Personales en Posesión de Sujetos Obligados, y demás normatividad que resulte aplicable.
                </p>

                <h2 class="text-xl font-semibold mb-2 mt-6">¿Para qué fines utilizaremos sus datos personales?</h2>
                <p class="mb-4">Los datos personales que solicitamos los utilizaremos para las siguientes finalidades:</p>
                <ul class="list-disc pl-5 mb-4">
                    <li>Gestionar su expediente académico para el proceso de residencias profesionales.</li>
                    <li>Vincularlo con las empresas y asesores organizacionales.</li>
                    <li>Emitir constancias, actas y documentos oficiales de liberación.</li>
                    <li>Fines estadísticos y de seguimiento interno.</li>
                </ul>

                <h2 class="text-xl font-semibold mb-2 mt-6">¿Qué datos personales utilizaremos para estos fines?</h2>
                <p class="mb-4">Para llevar a cabo las finalidades descritas en el presente aviso de privacidad, utilizaremos los siguientes datos personales:</p>
                <ul class="list-disc pl-5 mb-4">
                    <li>Nombre completo</li>
                    <li>Matrícula, carrera y cuatrimestre</li>
                    <li>Correo electrónico institucional o personal</li>
                    <li>Información de la empresa receptora y asesor organizacional</li>
                </ul>

                <h2 class="text-xl font-semibold mb-2 mt-6">Seguridad de la información</h2>
                <p class="mb-4">
                    Implementamos medidas de seguridad técnicas (cifrado de contraseñas, acceso mediante protocolos seguros HTTPS) 
                    y administrativas para proteger sus datos personales contra daño, pérdida, alteración, destrucción o el uso, 
                    acceso o tratamiento no autorizado.
                </p>

                <div class="mt-8 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Última actualización: {{ date('d/m/Y') }}</p>
                    
                    <div class="mt-6 flex justify-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-utgz-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-utgz-accent focus:ring-offset-2 transition ease-in-out duration-150">
                            Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
