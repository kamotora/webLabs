package local.autorepair.lab2.util;

import java.util.ArrayList;
import java.util.List;

public class ParseCheckboxFromBody {
    /**
     * Парсит с bodySty строки с servicesCheck{id} и  возвращает id для тех, где servicesCheck{id} = on
     * @param bodyStr - request body
     * */
    public static List<Long> getResult(String bodyStr) {
        List<Long> result = new ArrayList<>();
        String[] values = bodyStr.split("&");
        final String FOR_FIND = "servicesCheck";
        for (String value : values) {
            if(!value.startsWith(FOR_FIND))
                continue;
            String[] pair = value.split("=");
            if(pair[1].equals("on")){
                result.add(Long.valueOf(pair[0].substring(FOR_FIND.length())));
            }
        }
        return result;
    }
}
