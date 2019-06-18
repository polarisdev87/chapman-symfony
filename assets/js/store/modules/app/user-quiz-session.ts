import {ActionTree, GetterTree, Module, MutationTree} from "vuex";
import {RootState} from "../../index";
import service from "../../../utils/request";
import {ExistFilter, FilterBuilder} from "../../../api/filters/filter";
import {HydraCollection} from "../../../entity/hydra";
import QuizSession from "../../../entity/quiz-session";

export interface SessionState {
    session: QuizSession,
    isLoading: boolean
}

const QUIZ_SESSION_SET_SESSION = "QUIZ_SESSION_SET_SESSION";
const QUIZ_SESSION_CLEAR_SESSION = "QUIZ_SESSION_CLEAR_SESSION";
const QUIZ_SESSION_SET_LOADING = "QUIZ_SESSION_SET_LOADING";

const mutations: MutationTree<SessionState> = {
    [QUIZ_SESSION_SET_SESSION]: (state, session : QuizSession) => {
        state.session = session;
    },
    [QUIZ_SESSION_CLEAR_SESSION]: (state, session) => {
        state.session = null;
    },
    [QUIZ_SESSION_SET_LOADING]: (state, isLoading: boolean) => {
        state.isLoading = isLoading;
    }
};

const getters: GetterTree<SessionState,RootState> = {
    session: state => state.session,
    isLoading: state => state.isLoading
};

const actions: ActionTree<SessionState,RootState> = {
    begin(context,access){

    },
    submitQuestions(context) : Promise<QuizSession>
    {
        return null;
    },
    start(context): Promise<QuizSession> {
        return null;
    },
    check(context) : Promise<QuizSession>{
        const builder = new FilterBuilder();
        // get entries that are not submitted
        builder.addFilter(new ExistFilter("submittedAt",false));

        return new Promise((resolve,reject) => {
            context.commit(QUIZ_SESSION_SET_LOADING,true);

            service({
                url: '/_api/quiz_sessions?' + builder.build(),
                method: 'GET'
            }).then((response) => {
                const collection: HydraCollection<QuizSession> = response.data;

                if(collection["hydra:member"].length > 0){
                    const session = collection["hydra:member"][0];
                    context.commit(QUIZ_SESSION_SET_SESSION,session);
                    resolve(session);
                }else{
                    context.commit(QUIZ_SESSION_CLEAR_SESSION);
                    resolve(null);
                }
                context.commit(QUIZ_SESSION_SET_LOADING,false);

            }).catch((error) => {
                console.log(error);
                context.commit(QUIZ_SESSION_SET_LOADING,false);
                reject(error);
            })
        });
    }
};


export const userQuizSession: Module<SessionState,RootState> = {
    namespaced:true,
    state: {
        session: null,
        isLoading:false
    },
    mutations,
    getters,
    actions,
};