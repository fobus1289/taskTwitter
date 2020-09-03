<?php

namespace crutch;

/**
 * @example request helper
 * @author Xotam <fobus1289@mail.ru>
 */
class Request extends AbstractRequest
{
    
    # можно переопределить этот метнод
    # возвращает массив get post put patch delete итд
    # пишем какой метнод пропускать или исключение 405
    # если не переопределен то пропускает все методы
    # можем добавить значение сообщение message => 'This method is not supported'
    protected function methodsAllowed()
    {
        return [
            'get',
            'post', 
            'put' ,
            'patch',
            'delete',
            'message' => 'этот метнод не подеживаетса',
            //... other http methods
        ];
    }
    
    # ленивая проверка запроса
    # примечание когда эта работает ,
    # если есть эти данные то начинается валидация этих данных
    # он может быть или нет если нет то пропускает (ignore)
    # прелесть в том что когда надо обновить какой то из полей в базе данных
    # мы отправляем нужные данные
    # если незнать какие данные придут то if else ? тут решается эта проблема
    # проверка файла тип(mime-type) расширение размер
    public function rulesLazy(IMayBe $validator)
    {
        
    }
    
    # примечание тут проверяется сразу входящие данные
    # если нет этих данных то исключение
    # не проходят валидации исключение
    # всё ок пропускаем
    # в rules или rulesLazy может удалить не нужные данные
    # this->removeAny(['id','name','итд']) полезно когда обновляем данные и не надо проверять
    public function rules(IValidator $validator)
    {
        
    }
    
    # схема
    # required 
    # min 
    # max 
    # number
    # float 
    # confirmation 
    # unique 
    # email 
    # file 
    # file.size 
    # file.type 
    # file.extension 
    # подерживает rules и rulesLazy
    # пишем по схеме и радуемся :)
    protected function messages()
    {
        return [
            'key_name.required'       => 'сюда собщение об ошибке',
            'key_name.min'            => 'сюда собщение об ошибке',
            'key_name.max'            => 'сюда собщение об ошибке',
            'key_name.number'         => 'сюда собщение об ошибке',
            'key_name.float'          => 'сюда собщение об ошибке',
            'key_name.confirmation'   => 'сюда собщение об ошибке',
            'key_name.unique'         => 'сюда собщение об ошибке',
            'key_name.unique.no'      => 'сюда собщение об ошибке',
            'key_name.email'          => 'сюда собщение об ошибке',
            'key_name.file'           => 'сюда собщение об ошибке',
            'key_name.file.size'      => 'сюда собщение об ошибке',
            'key_name.file.type'      => 'сюда собщение об ошибке',
            'key_name.file.extension' => 'сюда собщение об ошибке',
        ];
    }
    
    
    protected function error($array) 
    {
        
    }
    
    # проверка файла тип(mime-type)
    # тут всё просто указываем mime-type файлов которых надо проверять
    # validator->fileCheck('photo.image', '*', -1)
    # validator->fileCheck('photo.video', ['mp4','fly'], -1)
    # размер файла в килобайтах 1 kb ... 1024 1 mb
    # если -1 то ограничение нету
    # можно переопределить 
    # соблюдать эту схему 'name' => ['mime-type']
    protected function specialCheckFile()
    {
        return [
            //Изображение
            'image' => [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/svg+xml',
                'image/tiff',
                'image/vnd.microsoft.icon',
                'image/vnd.wap.wbmp',
                'image/webp'  
            ],
            //Видео
            'video' => [
                'video/mpeg',
                'video/mp4',
                'video/ogg',
                'video/quickti',
                'video/webm',
                'video/x-ms-wm',
                'video/x-flv',
                'video/3gpp',
                'video/3gpp2',
            ],
            //Вендорные файлы
            'application' => [
                'application/vnd.oasis.opendocument.text',
                'application/vnd.oasis.opendocument.spreadsheet',
                'application/vnd.oasis.opendocument.presentation',
                'application/vnd.oasis.opendocument.graphics',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel.sheet.macroEnabled.12',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.mozilla.xul+xml',
                'application/vnd.google-earth.kml+xml',
            ],
            //Текст
            'text' => [
                'text/cmd',
                'text/css',
                'text/csv',
                'text/html',
                'text/javascript',
                'text/plain',
                'text/php',
                'text/xml',
                'text/markdown',
                'text/cache-manifest',
            ],
        ];
    }
 
}
